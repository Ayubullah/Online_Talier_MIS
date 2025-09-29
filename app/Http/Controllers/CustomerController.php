<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Phone;
use App\Models\InvoiceTb;
use App\Models\ClothM;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clothMeasurements = ClothM::with(['customer', 'clothAssignments'])
            ->paginate(15);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $clothMeasurements,
            ]);
        }

        // Return view for web requests
        return view('cloth.customers.index', compact('clothMeasurements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Create form data',
            ]);
        }

        // Return view for web requests
        return view('cloth.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Debug logging
            Log::info('Form submission received', [
                'form_mode' => $request->form_mode,
                'custname' => $request->custname,
                'phone' => $request->phone,
                'family_phone' => $request->family_phone,
                'family_name' => $request->family_name,
                'Total' => $request->Total,
                'Paid' => $request->Paid
            ]);

            // Get form data arrays
            $formMode = $request->form_mode ?? 'single';
            $customerNames = $request->custname ?? [];
            $phoneNumbers = $request->phone ?? [];
            $familyPhone = $request->family_phone;
            $familyName = $request->family_name;
            $totalAmount = floatval($request->Total ?? 0);
            $paidAmount = floatval($request->Paid ?? 0);

            // Validate based on form mode
            if (empty($customerNames)) {
                return redirect()->back()->withErrors(['error' => 'At least one customer record is required.']);
            }

            if ($formMode === 'family') {
                // Family mode validation
                if (empty($familyPhone) || empty($familyName)) {
                    return redirect()->back()->withErrors(['error' => 'Family name and phone number are required in family mode.']);
                }
            } else {
                // Individual mode validation
                if (empty($phoneNumbers)) {
                    return redirect()->back()->withErrors(['error' => 'Phone numbers are required for individual customers.']);
                }
            }

            // Create main invoice with total amount for all customers
            $invoice_data = new InvoiceTb();
            $invoice_data->inc_date = date('Y-m-d');
            $invoice_data->total_amt = $totalAmount;
            $invoice_data->status = $paidAmount >= $totalAmount ? 'paid' : 'unpaid';
            $invoice_data->save();

            // Create payment record if there's a paid amount
            if ($paidAmount > 0) {
                $payment_data = new Payment();
                $payment_data->F_inc_id = $invoice_data->inc_id;
                $payment_data->amount = $paidAmount;
                $payment_data->paid_at = date('Y-m-d');
                $payment_data->save();
            }

            $createdCustomers = [];
            $familyPhoneId = null;

            // Handle family mode - create single phone record for all family members
            if ($formMode === 'family') {
                $phone_data = new Phone();
                $phone_data->pho_no = $familyPhone;
                $phone_data->save();
                $familyPhoneId = $phone_data->pho_id;
            }

            // Loop through each measurement section and create records
            for ($i = 0; $i < count($customerNames); $i++) {
                $phoneId = null;

                if ($formMode === 'family') {
                    // Use shared family phone
                    $phoneId = $familyPhoneId;
                } else {
                    // Create individual phone record
                    $phone_data = new Phone();
                    $phone_data->pho_no = $phoneNumbers[$i] ?? '';
                    $phone_data->save();
                    $phoneId = $phone_data->pho_id;
                }

                // Create customer record
                $customer_data = new Customer();
                $customer_data->cus_name = $customerNames[$i];
                $customer_data->F_pho_id = $phoneId;
                $customer_data->F_inv_id = $invoice_data->inc_id;
                $customer_data->save();

                // Create cloth measurement record
                $cloth_data = new ClothM();
                $cloth_data->F_cus_id = $customer_data->cus_id;
                $cloth_data->size = $request->cloth_size[$i] ?? 'L';
                $cloth_data->Height = $request->Height[$i] ?? '';
                $cloth_data->Shoulder = $request->Shoulder[$i] ?? '';
                $cloth_data->Sleeve = $request->Sleeve[$i] ?? '';
                $cloth_data->Collar = $request->Collar[$i] ?? '';
                $cloth_data->chati = $request->chati[$i] ?? '';
                $cloth_data->Armpit = $request->Armpit[$i] ?? '';
                $cloth_data->Skirt = $request->Skirt[$i] ?? '';
                $cloth_data->Trousers = $request->Trouser[$i] ?? '';
                $cloth_data->Pacha = $request->pacha[$i] ?? '';
                $cloth_data->Kaff = $request->Kaff[$i] ?? '';
                $cloth_data->size_kaf = $request->size_kaf[$i] ?? '';
                $cloth_data->sleeve_type = $request->sleeve_type[$i] ?? '';
                $cloth_data->size_sleve = $request->size_sleve[$i] ?? '';
                $cloth_data->Kalar = $request->Kalar[$i] ?? '';
                $cloth_data->Shalwar = $request->Shalwar[$i] ?? '';
                $cloth_data->Daman = $request->Daman[$i] ?? '';
                $cloth_data->Jeb = $request->Jeb[$i] ?? '';
                $cloth_data->O_date = $request->Order_date[$i] ?? date('Y-m-d');
                $cloth_data->R_date = $request->Receive_date[$i] ?? date('Y-m-d');
                $cloth_data->cloth_rate = $request->Rate[$i] ?? 0;
                $cloth_data->order_status = 'pending';
                $cloth_data->save();

                $createdCustomers[] = $customer_data->cus_name;
            }

            $customerCount = count($createdCustomers);
            $customerList = implode(', ', $createdCustomers);

            if ($formMode === 'family') {
                return redirect()->route('customers.index')
                    ->with('success', "Successfully created family '{$familyName}' with {$customerCount} member(s): {$customerList} (Phone: {$familyPhone})")
                    ->with('invoice_id', $invoice_data->inc_id);
            } else {
                return redirect()->route('customers.index')
                    ->with('success', "Successfully created {$customerCount} customer record(s): {$customerList}")
                    ->with('invoice_id', $invoice_data->inc_id);
            }

        } catch (\Exception $e) {
            Log::error('Error creating customers: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating customer records: ' . $e->getMessage()]);
        }
    }

    /**
     * Search customers by phone number
     */
    public function searchByPhone(Request $request)
    {
        $phoneNumber = $request->input('phone_number');
        
        if (empty($phoneNumber)) {
            return response()->json(['customers' => []]);
        }

        $customers = Customer::with(['phone', 'clothMeasurements', 'vestMeasurements', 'customerPayments'])
                           ->whereHas('phone', function ($query) use ($phoneNumber) {
                               $query->where('pho_no', 'like', '%' . $phoneNumber . '%');
                           })
                           ->get()
                           ->map(function ($customer) {
                               return [
                                   'id' => $customer->cus_id,
                                   'name' => $customer->cus_name,
                                   'phone' => $customer->phone ? $customer->phone->pho_no : 'No phone',
                                   'total_owed' => $customer->total_owed,
                                   'total_paid' => $customer->total_paid,
                                   'total_order_value' => $customer->total_order_value,
                                   'cloth_orders' => $customer->clothMeasurements->count(),
                                   'vest_orders' => $customer->vestMeasurements->count(),
                               ];
                           });

        return response()->json(['customers' => $customers]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Check if the ID is for a cloth measurement or customer
        $customer = null;

        // First, try to find by customer ID
        $customer = Customer::find($id);

        // If not found as customer, try to find as cloth measurement and get the customer
        if (!$customer) {
            $clothMeasurement = ClothM::find($id);
            if ($clothMeasurement) {
                $customer = $clothMeasurement->customer;
            }
        }

        // If still not found, return 404
        if (!$customer) {
            abort(404, 'Customer not found');
        }

        // Load relationships for the view
        $customer->load([
            'phone',
            'invoice',
            'clothMeasurements',
            'vestMeasurements',
            'customerPayments'
        ]);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $customer,
            ]);
        }

        // Return view for web requests
        return view('cloth.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Check if the ID is for a cloth measurement or customer
        $customer = null;

        // First, try to find by customer ID
        $customer = Customer::find($id);

        // If not found as customer, try to find as cloth measurement and get the customer
        if (!$customer) {
            $clothMeasurement = ClothM::find($id);
            if ($clothMeasurement) {
                $customer = $clothMeasurement->customer;
            }
        }

        // If still not found, return 404
        if (!$customer) {
            abort(404, 'Customer not found');
        }

        // Load relationships
        $customer->load(['phone', 'clothMeasurements', 'invoice']);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $customer,
            ]);
        }

        // Return view for web requests
        return view('cloth.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'cus_name' => 'required|string|max:50',
            'phone_number' => 'nullable|string|max:14',
            'cloth_size' => 'nullable|in:l,s',
            'Height' => 'nullable|string|max:10',
            'Shoulder' => 'nullable|integer',
            'Sleeve' => 'nullable|integer',
            'Collar' => 'nullable|string|max:15',
            'chati' => 'nullable|string|max:255',
            'Armpit' => 'nullable|string|max:15',
            'Skirt' => 'nullable|string|max:15',
            'Trouser' => 'nullable|string|max:15',
            'pacha' => 'nullable|string|max:15',
            'Kaff' => 'nullable|string|max:40',
            'size_kaf' => 'nullable|string|max:10',
            'sleeve_type' => 'nullable|string|max:40',
            'size_sleve' => 'nullable|string|max:10',
            'Kalar' => 'nullable|string|max:15',
            'Shalwar' => 'nullable|string|max:15',
            'Daman' => 'nullable|string|max:15',
            'Jeb' => 'nullable|string|max:60',
            'O_date' => 'nullable|date',
            'R_date' => 'nullable|date',
            'cust_name' => 'nullable|string|max:50',
            'cloth_rate' => 'nullable|numeric|min:0',
        ]);

        $phoneId = $customer->F_pho_id;
        if ($request->phone_number) {
            $phone = Phone::firstOrCreate(['pho_no' => $request->phone_number]);
            $phoneId = $phone->pho_id;
        }

        $customer->update([
            'cus_name' => $request->cus_name,
            'F_pho_id' => $phoneId,
            'F_inv_id' => $request->F_inv_id,
        ]);

        // Update or create cloth measurement for this customer
        $clothMeasurement = $customer->clothMeasurements()->first();

        if ($clothMeasurement) {
            // Update existing measurement
            $clothMeasurement->update([
                'size' => $request->cloth_size ?? $clothMeasurement->size,
                'Height' => $request->Height ?? $clothMeasurement->Height,
                'Shoulder' => $request->Shoulder ?? $clothMeasurement->Shoulder,
                'Sleeve' => $request->Sleeve ?? $clothMeasurement->Sleeve,
                'Collar' => $request->Collar ?? $clothMeasurement->Collar,
                'chati' => $request->chati ?? $clothMeasurement->chati,
                'Armpit' => $request->Armpit ?? $clothMeasurement->Armpit,
                'Skirt' => $request->Skirt ?? $clothMeasurement->Skirt,
                'Trousers' => $request->Trouser ?? $clothMeasurement->Trousers,
                'Pacha' => $request->pacha ?? $clothMeasurement->Pacha,
                'Kaff' => $request->Kaff ?? $clothMeasurement->Kaff,
                'size_kaf' => $request->size_kaf ?? $clothMeasurement->size_kaf,
                'sleeve_type' => $request->sleeve_type ?? $clothMeasurement->sleeve_type,
                'size_sleve' => $request->size_sleve ?? $clothMeasurement->size_sleve,
                'Kalar' => $request->Kalar ?? $clothMeasurement->Kalar,
                'Shalwar' => $request->Shalwar ?? $clothMeasurement->Shalwar,
                'Daman' => $request->Daman ?? $clothMeasurement->Daman,
                'Jeb' => $request->Jeb ?? $clothMeasurement->Jeb,
                'O_date' => $request->O_date ?? $clothMeasurement->O_date,
                'R_date' => $request->R_date ?? $clothMeasurement->R_date,
                'cust_name' => $request->cust_name ?? $clothMeasurement->cust_name,
                'cloth_rate' => $request->cloth_rate ?? $clothMeasurement->cloth_rate,
            ]);
        } else {
            // Create new measurement if none exists
            \App\Models\ClothM::create([
                'F_cus_id' => $customer->cus_id,
                'size' => $request->cloth_size,
                'Height' => $request->Height,
                'Shoulder' => $request->Shoulder,
                'Sleeve' => $request->Sleeve,
                'Collar' => $request->Collar,
                'chati' => $request->chati,
                'Armpit' => $request->Armpit,
                'Skirt' => $request->Skirt,
                'Trousers' => $request->Trouser,
                'Pacha' => $request->pacha,
                'Kaff' => $request->Kaff,
                'size_kaf' => $request->size_kaf,
                'sleeve_type' => $request->sleeve_type,
                'size_sleve' => $request->size_sleve,
                'Kalar' => $request->Kalar,
                'Shalwar' => $request->Shalwar,
                'Daman' => $request->Daman,
                'Jeb' => $request->Jeb,
                'O_date' => $request->O_date,
                'R_date' => $request->R_date,
                'cust_name' => $request->cust_name,
                'cloth_rate' => $request->cloth_rate,
                'order_status' => 'pending',
            ]);
        }

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Customer and measurements updated successfully.',
                'data' => $customer->load(['phone', 'invoice', 'clothMeasurements']),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer and measurements updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the ID is for a cloth measurement or customer
        $customer = null;

        // First, try to find by customer ID
        $customer = Customer::find($id);

        // If not found as customer, try to find as cloth measurement and get the customer
        if (!$customer) {
            $clothMeasurement = ClothM::find($id);
            if ($clothMeasurement) {
                $customer = $clothMeasurement->customer;
            }
        }

        // If still not found, return 404
        if (!$customer) {
            abort(404, 'Customer not found');
        }

        $customer->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully.',
            ]);
        }

        // Redirect for web requests
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    /**
     * Print invoice for cloth order
     */
    public function printInvoice($invoiceId)
    {
        // Get all cloth measurements for this invoice
        $cloths = ClothM::with(['customer.phone'])
            ->whereHas('customer', function($query) use ($invoiceId) {
                $query->where('F_inv_id', $invoiceId);
            })
            ->get();

        // Get invoice details
        $invoice = InvoiceTb::find($invoiceId);
        
        if (!$invoice || $cloths->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Invoice not found or no cloth records.']);
        }

        // Calculate totals
        $totalRate = $cloths->sum('cloth_rate');
        $totalPaid = Payment::where('F_inc_id', $invoiceId)->sum('amount');
        $totalRemain = $totalRate - $totalPaid;

        return view('cloth.customers.print', compact('cloths', 'invoice', 'totalRate', 'totalPaid', 'totalRemain', 'invoiceId'));
    }

    /**
     * Print individual cloth measurement by cm_id
     */
    public function printSize($cmId)
    {
        // Get the cloth measurement with customer, phone, and invoice details
        $cloth = ClothM::with(['customer.phone', 'customer.invoice'])->find($cmId);

        if (!$cloth) {
            return redirect()->back()->withErrors(['error' => 'Cloth measurement not found.']);
        }

        // Get invoice details if available (already loaded via eager loading)
        $invoice = $cloth->customer->invoice ?? null;

        return view('cloth.customers.sizePrint', compact('cloth', 'invoice'));
    }
}
