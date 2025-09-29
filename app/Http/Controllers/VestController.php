<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Phone;
use App\Models\InvoiceTb;
use App\Models\VestM;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vestMeasurements = VestM::with(['customer', 'clothAssignments'])
            ->paginate(15);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $vestMeasurements,
            ]);
        }

        // Return view for web requests
        return view('vest.index', compact('vestMeasurements'));
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
        return view('vest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Debug logging
            Log::info('Vest form submission received', [
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

                // Create vest measurement record
                $vest_data = new VestM();
                $vest_data->F_cus_id = $customer_data->cus_id;
                $vest_data->size = $request->Clothes_Size[$i] ?? 'L';
                $vest_data->Vest_Type = $request->Vest_Type[$i] ?? '';
                $vest_data->Height = $request->Height[$i] ?? '';
                $vest_data->Shoulder = $request->Shoulder[$i] ?? '';
                $vest_data->Armpit = $request->Armpit[$i] ?? '';
                $vest_data->Waist = $request->Waist[$i] ?? '';
                $vest_data->Shana = $request->Shana[$i] ?? '';
                $vest_data->Kalar = $request->Kalar[$i] ?? '';
                $vest_data->Daman = $request->Daman[$i] ?? '';
                $vest_data->NawaWaskat = $request->NawaWaskat[$i] ?? '';
                $vest_data->O_date = $request->O_date[$i] ?? date('Y-m-d');
                $vest_data->R_date = $request->R_date[$i] ?? date('Y-m-d');
                $vest_data->vest_rate = $request->Rate[$i] ?? 0;
                $vest_data->Status = 'pending';
                $vest_data->save();

                $createdCustomers[] = $customer_data->cus_name;
            }

            $customerCount = count($createdCustomers);
            $customerList = implode(', ', $createdCustomers);

            if ($formMode === 'family') {
                return redirect()->route('vests.index')
                    ->with('success', "Successfully created vest order for family '{$familyName}' with {$customerCount} member(s): {$customerList} (Phone: {$familyPhone})")
                    ->with('invoice_id', $invoice_data->inc_id);
            } else {
                return redirect()->route('vests.index')
                    ->with('success', "Successfully created {$customerCount} vest order(s): {$customerList}")
                    ->with('invoice_id', $invoice_data->inc_id);
            }

        } catch (\Exception $e) {
            Log::error('Error creating vest orders: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating vest records: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VestM $vest)
    {
        // Load relationships for the view
        $vest->load('customer.phone', 'customer.invoice');

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $vest,
            ]);
        }

        // Return view for web requests
        return view('vest.show', compact('vest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VestM $vest)
    {
        // Load customer relationship
        $vest->load('customer.phone', 'customer.invoice');

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $vest,
            ]);
        }

        // Return view for web requests
        return view('vest.edit', compact('vest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VestM $vest)
    {
        $request->validate([
            'cus_name' => 'required|string|max:50',
            'phone_number' => 'nullable|string|max:14',
            'size' => 'nullable|string|in:S,L',
            'Vest_Type' => 'nullable|string|max:50',
            'vest_rate' => 'nullable|numeric',
            'Status' => 'required|string|in:pending,completed',
            'Height' => 'nullable|string|max:20',
            'Shoulder' => 'nullable|string|max:20',
            'Armpit' => 'nullable|string|max:20',
            'Waist' => 'nullable|string|max:20',
            'Shana' => 'nullable|string|max:50',
            'Kalar' => 'nullable|string|max:50',
            'Daman' => 'nullable|string|max:50',
            'NawaWaskat' => 'nullable|string|max:50',
            'O_date' => 'nullable|date',
            'R_date' => 'nullable|date',
        ]);

        // Update customer information if provided
        $customer = $vest->customer;
        if ($request->cus_name) {
            $customer->cus_name = $request->cus_name;
        }

        if ($request->phone_number) {
            $phone = Phone::firstOrCreate(['pho_no' => $request->phone_number]);
            $customer->F_pho_id = $phone->pho_id;
        }

        $customer->save();

        // Update vest information
        $vest->update([
            'size' => $request->size ?? $vest->size,
            'Vest_Type' => $request->Vest_Type ?? $vest->Vest_Type,
            'vest_rate' => $request->vest_rate ?? $vest->vest_rate,
            'Status' => $request->Status,
            'Height' => $request->Height ?? $vest->Height,
            'Shoulder' => $request->Shoulder ?? $vest->Shoulder,
            'Armpit' => $request->Armpit ?? $vest->Armpit,
            'Waist' => $request->Waist ?? $vest->Waist,
            'Shana' => $request->Shana ?? $vest->Shana,
            'Kalar' => $request->Kalar ?? $vest->Kalar,
            'Daman' => $request->Daman ?? $vest->Daman,
            'NawaWaskat' => $request->NawaWaskat ?? $vest->NawaWaskat,
            'O_date' => $request->O_date ?? $vest->O_date,
            'R_date' => $request->R_date ?? $vest->R_date,
        ]);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vest order updated successfully.',
                'data' => $vest->load('customer.phone', 'customer.invoice'),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('vests.show', $vest)
            ->with('success', 'Vest order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VestM $vest)
    {
        $vest->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vest order deleted successfully.',
            ]);
        }

        // Redirect for web requests
        return redirect()->route('vests.index')
            ->with('success', 'Vest order deleted successfully.');
    }

    /**
     * Print invoice for vest order
     */
    public function printInvoice($invoiceId)
    {
        // Get all vest measurements for this invoice
        $vests = VestM::with(['customer.phone'])
            ->whereHas('customer', function($query) use ($invoiceId) {
                $query->where('F_inv_id', $invoiceId);
            })
            ->get();

        // Get invoice details
        $invoice = InvoiceTb::find($invoiceId);
        
        if (!$invoice || $vests->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Invoice not found or no vest records.']);
        }

        // Calculate totals
        $totalRate = $vests->sum('vest_rate');
        $totalPaid = Payment::where('F_inc_id', $invoiceId)->sum('amount');
        $totalRemain = $totalRate - $totalPaid;

        return view('vest.print', compact('vests', 'invoice', 'totalRate', 'totalPaid', 'totalRemain', 'invoiceId'));
    }

    /**
     * Print size for individual vest measurement
     */
    public function printSize($vestId)
    {
        $vest = VestM::with(['customer.phone', 'customer.invoice'])->find($vestId);
        
        if (!$vest) {
            return redirect()->back()->withErrors(['error' => 'Vest measurement not found.']);
        }

        return view('vest.sizePrint', compact('vest'));
    }
}