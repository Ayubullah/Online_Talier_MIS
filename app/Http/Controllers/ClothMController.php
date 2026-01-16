<?php

namespace App\Http\Controllers;

use App\Models\ClothM;
use App\Models\Customer;
use App\Models\InvoiceTb;
use App\Models\Payment;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClothMController extends Controller
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

        // Return view for web requests - check route name to determine view
        if (request()->route()->getName() === 'cloth.index') {
            return view('cloth.index', compact('clothMeasurements'));
        }
        return view('cloth.index', compact('clothMeasurements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => ['customers' => $customers],
            ]);
        }

        // Return view for web requests - check route name to determine view
        if (request()->route()->getName() === 'cloth.create') {
            return view('cloth.create', compact('customers'));
        }
        return view('cloth-measurements.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $formMode = $request->input('form_mode', 'single');
            
            // Get form data arrays
            $customerNames = $request->custname ?? [];
            $phoneNumbers = $request->phone ?? [];
            $familyPhone = $request->family_phone;
            $familyName = $request->family_name;
            
            // Validate based on form mode
            if ($formMode === 'family') {
                $request->validate([
                    'family_name' => 'required|string|max:50',
                    'family_phone' => 'required|string|max:14',
                    'Total' => 'required|numeric|min:0',
                    'Paid' => 'required|numeric|min:0',
                    'custname' => 'required|array|min:1',
                    'custname.*' => 'required|string|max:50',
                    'cloth_size' => 'required|array|min:1',
                    'cloth_size.*' => 'required|in:S,L',
                    'Height' => 'required|array|min:1',
                    'Height.*' => 'required|string|max:10',
                    'chati' => 'required|array|min:1',
                    'chati.*' => 'required|string|max:255',
                    'Sleeve' => 'required|array|min:1',
                    'Sleeve.*' => 'required|string',
                    'Shoulder' => 'required|array|min:1',
                    'Shoulder.*' => 'required|string',
                    'Collar' => 'required|array|min:1',
                    'Collar.*' => 'required|string|max:15',
                    'Armpit' => 'required|array|min:1',
                    'Armpit.*' => 'required|string|max:15',
                    'Skirt' => 'required|array|min:1',
                    'Skirt.*' => 'required|string|max:15',
                    'Trouser' => 'required|array|min:1',
                    'Trouser.*' => 'required|string|max:15',
                    'pacha' => 'required|array|min:1',
                    'pacha.*' => 'required|string|max:15',
                    'Kaff' => 'required|array|min:1',
                    'Kaff.*' => 'required|string|max:40',
                    'sleeve_type' => 'required|array|min:1',
                    'sleeve_type.*' => 'required|string|max:40',
                    'Kalar' => 'required|array|min:1',
                    'Kalar.*' => 'required|string|max:15',
                    'Shalwar' => 'required|array|min:1',
                    'Shalwar.*' => 'required|string|max:15',
                    'Daman' => 'required|array|min:1',
                    'Daman.*' => 'required|string|max:15',
                    'Jeb' => 'nullable|array',
                    'Jeb.*' => 'nullable|string|max:60',
                    'O_date' => 'required|array|min:1',
                    'O_date.*' => 'required|date',
                    'R_date' => 'required|array|min:1',
                    'R_date.*' => 'required|date',
                    'Rate' => 'required|array|min:1',
                    'Rate.*' => 'required|numeric|min:0',
                ]);
            } else {
                $request->validate([
                    'custname' => 'required|array|min:1',
                    'custname.*' => 'required|string|max:50',
                    'phone' => 'required|array|min:1',
                    'phone.*' => 'required|string|max:14',
                    'Total' => 'required|numeric|min:0',
                    'Paid' => 'required|numeric|min:0',
                    'cloth_size' => 'required|array|min:1',
                    'cloth_size.*' => 'required|in:S,L',
                    'Height' => 'required|array|min:1',
                    'Height.*' => 'required|string|max:10',
                    'chati' => 'required|array|min:1',
                    'chati.*' => 'required|string|max:255',
                    'Sleeve' => 'required|array|min:1',
                    'Sleeve.*' => 'required|string',
                    'Shoulder' => 'required|array|min:1',
                    'Shoulder.*' => 'required|string',
                    'Collar' => 'required|array|min:1',
                    'Collar.*' => 'required|string|max:15',
                    'Armpit' => 'required|array|min:1',
                    'Armpit.*' => 'required|string|max:15',
                    'Skirt' => 'required|array|min:1',
                    'Skirt.*' => 'required|string|max:15',
                    'Trouser' => 'required|array|min:1',
                    'Trouser.*' => 'required|string|max:15',
                    'pacha' => 'required|array|min:1',
                    'pacha.*' => 'required|string|max:15',
                    'Kaff' => 'required|array|min:1',
                    'Kaff.*' => 'required|string|max:40',
                    'sleeve_type' => 'required|array|min:1',
                    'sleeve_type.*' => 'required|string|max:40',
                    'Kalar' => 'required|array|min:1',
                    'Kalar.*' => 'required|string|max:15',
                    'Shalwar' => 'required|array|min:1',
                    'Shalwar.*' => 'required|string|max:15',
                    'Daman' => 'required|array|min:1',
                    'Daman.*' => 'required|string|max:15',
                    'Jeb' => 'nullable|array',
                    'Jeb.*' => 'nullable|string|max:60',
                    'O_date' => 'required|array|min:1',
                    'O_date.*' => 'required|date',
                    'R_date' => 'required|array|min:1',
                    'R_date.*' => 'required|date',
                    'Rate' => 'required|array|min:1',
                    'Rate.*' => 'required|numeric|min:0',
                ]);
            }

            // Validate that we have at least one customer record
            if (empty($customerNames)) {
                return redirect()->back()->withErrors(['error' => 'At least one customer record is required.'])->withInput();
            }

            // Create invoice
            $totalAmount = $request->input('Total', 0);
            $paidAmount = $request->input('Paid', 0);
            
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

            // Handle family phone if in family mode
            $familyPhoneId = null;
            if ($formMode === 'family') {
                if (empty($familyPhone) || empty($familyName)) {
                    return redirect()->back()->withErrors(['error' => 'Family name and phone number are required in family mode.'])->withInput();
                }
                $phone = Phone::firstOrCreate(['pho_no' => $familyPhone]);
                $familyPhoneId = $phone->pho_id;
            }

            // Loop through each measurement section and create records
            $createdCustomers = [];
            for ($i = 0; $i < count($customerNames); $i++) {
                $phoneId = null;

                if ($formMode === 'family') {
                    // Use shared family phone
                    $phoneId = $familyPhoneId;
                } else {
                    // Create individual phone record
                    if (empty($phoneNumbers[$i])) {
                        continue; // Skip if no phone number
                    }
                    $phone = Phone::firstOrCreate(['pho_no' => $phoneNumbers[$i]]);
                    $phoneId = $phone->pho_id;
                }

                // Create customer record
                $customer_data = new Customer();
                $customer_data->cus_name = $customerNames[$i];
                $customer_data->F_pho_id = $phoneId;
                $customer_data->F_inv_id = $invoice_data->inc_id;
                $customer_data->save();

                // Create cloth measurement record
                $clothM = new ClothM();
                $clothM->F_cus_id = $customer_data->cus_id;
                $clothM->size = $request->cloth_size[$i] ?? 'L';
                $clothM->Height = $request->Height[$i] ?? '';
                $clothM->Shoulder = $request->Shoulder[$i] ?? '';
                $clothM->Sleeve = $request->Sleeve[$i] ?? '';
                $clothM->Collar = $request->Collar[$i] ?? '';
                $clothM->chati = $request->chati[$i] ?? '';
                $clothM->Armpit = $request->Armpit[$i] ?? '';
                $clothM->Skirt = $request->Skirt[$i] ?? '';
                $clothM->Trousers = $request->Trouser[$i] ?? '';
                $clothM->Pacha = $request->pacha[$i] ?? '';
                $clothM->Kaff = $request->Kaff[$i] ?? '';
                $clothM->size_kaf = $request->size_kaf[$i] ?? null;
                $clothM->sleeve_type = $request->sleeve_type[$i] ?? '';
                $clothM->size_sleve = $request->size_sleve[$i] ?? null;
                $clothM->Kalar = $request->Kalar[$i] ?? '';
                $clothM->Shalwar = $request->Shalwar[$i] ?? '';
                $clothM->Daman = $request->Daman[$i] ?? '';
                // Handle Jeb field - ensure it's null if empty to avoid encoding issues
                $jebValue = isset($request->Jeb[$i]) ? trim($request->Jeb[$i]) : '';
                $clothM->Jeb = !empty($jebValue) ? $jebValue : null;
                $clothM->O_date = $request->O_date[$i] ?? date('Y-m-d');
                $clothM->R_date = $request->R_date[$i] ?? date('Y-m-d');
                $clothM->cloth_rate = $request->Rate[$i] ?? 0;
                $clothM->order_status = 'pending';
                $clothM->save();

                $createdCustomers[] = $customer_data->cus_name;
            }

            $customerCount = count($createdCustomers);
            $customerList = implode(', ', $createdCustomers);

            // Check if the request wants JSON (API call)
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Successfully created {$customerCount} cloth measurement(s).",
                    'data' => ['customers' => $createdCustomers],
                ], 201);
            }

            // Redirect for web requests - check route name to determine redirect
            if (request()->route()->getName() === 'cloth.store') {
                if ($formMode === 'family') {
                    return redirect()->route('cloth.index')
                        ->with('success', "Successfully created family '{$familyName}' with {$customerCount} cloth measurement(s): {$customerList}")
                        ->with('invoice_id', $invoice_data->inc_id);
                } else {
                    return redirect()->route('cloth.index')
                        ->with('success', "Successfully created {$customerCount} cloth measurement(s): {$customerList}")
                        ->with('invoice_id', $invoice_data->inc_id);
                }
            }
            
            if ($formMode === 'family') {
                return redirect()->route('cloth-measurements.index')
                    ->with('success', "Successfully created family '{$familyName}' with {$customerCount} cloth measurement(s): {$customerList}")
                    ->with('invoice_id', $invoice_data->inc_id);
            } else {
                return redirect()->route('cloth-measurements.index')
                    ->with('success', "Successfully created {$customerCount} cloth measurement(s): {$customerList}")
                    ->with('invoice_id', $invoice_data->inc_id);
            }

        } catch (\Exception $e) {
            Log::error('Error creating cloth measurement: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while creating cloth measurement.',
                    'error' => $e->getMessage(),
                ], 500);
            }
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating cloth measurement: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the cloth measurement by ID
        $clothM = ClothM::with('customer.phone', 'customer.invoice', 'clothAssignments.employee')
            ->find($id);

        // Ensure the model exists
        if (!$clothM) {
            abort(404, 'Cloth measurement not found');
        }

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $clothM,
            ]);
        }

        // Return view for web requests - check route name to determine view
        if (request()->route()->getName() === 'cloth.show') {
            return view('cloth.show', compact('clothM'));
        }
        return view('cloth-measurements.show', compact('clothM'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the cloth measurement by ID with relationships
        $clothM = ClothM::with('customer.phone', 'customer.invoice', 'clothAssignments.employee')
            ->find($id);

        // Ensure the model exists
        if (!$clothM) {
            abort(404, 'Cloth measurement not found');
        }

        $customers = Customer::all();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => ['clothM' => $clothM, 'customers' => $customers],
            ]);
        }

        // Return view for web requests - check route name to determine view
        if (request()->route()->getName() === 'cloth.edit') {
            return view('cloth.edit', compact('clothM', 'customers'));
        }
        return view('cloth-measurements.edit', compact('clothM', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the cloth measurement
        $clothM = ClothM::find($id);
        if (!$clothM) {
            abort(404, 'Cloth measurement not found');
        }

        $request->validate([
            'cus_name' => 'required|string|max:50',
            'phone_number' => 'nullable|string|max:14',
            'size' => 'required|in:S,L',
            'cloth_rate' => 'required|numeric|min:0',
            'order_status' => 'nullable|in:pending,complete',
            'Height' => 'nullable|string|max:10',
            'chati' => 'nullable|string|max:255',
            'Sleeve' => 'nullable|integer',
            'Shoulder' => 'nullable|integer',
            'Collar' => 'nullable|string|max:15',
            'Armpit' => 'nullable|string|max:15',
            'Skirt' => 'nullable|string|max:15',
            'Trousers' => 'nullable|string|max:15',
            'Kaff' => 'nullable|string|max:40',
            'Pacha' => 'nullable|string|max:15',
            'sleeve_type' => 'nullable|string|max:40',
            'Kalar' => 'nullable|string|max:15',
            'Shalwar' => 'nullable|string|max:15',
            'Yakhan' => 'nullable|string|max:15',
            'Daman' => 'nullable|string|max:15',
            'Jeb' => 'nullable|string|max:60',
            'Waist' => 'nullable|string|max:20',
            'Shana' => 'nullable|string|max:50',
            'NawaWaskat' => 'nullable|string|max:50',
            'O_date' => 'nullable|date',
            'R_date' => 'nullable|date',
        ]);

        // Update customer information
        $customer = $clothM->customer;
        if ($customer) {
            $customer->cus_name = $request->cus_name;
            
            // Update phone if provided
            if ($request->phone_number) {
                $phone = Phone::firstOrCreate(['pho_no' => $request->phone_number]);
                $customer->F_pho_id = $phone->pho_id;
            }
            
            $customer->save();
        }

        // Update cloth measurement
        $clothM->update([
            'size' => $request->size,
            'cloth_rate' => $request->cloth_rate,
            'order_status' => $request->order_status ?? $clothM->order_status,
            'Height' => $request->Height,
            'chati' => $request->chati,
            'Sleeve' => $request->Sleeve,
            'Shoulder' => $request->Shoulder,
            'Collar' => $request->Collar,
            'Armpit' => $request->Armpit,
            'Skirt' => $request->Skirt,
            'Trousers' => $request->Trousers,
            'Kaff' => $request->Kaff,
            'Pacha' => $request->Pacha,
            'sleeve_type' => $request->sleeve_type,
            'Kalar' => $request->Kalar,
            'Shalwar' => $request->Shalwar,
            'Yakhan' => $request->Yakhan,
            'Daman' => $request->Daman,
            'Jeb' => $request->Jeb,
            'O_date' => $request->O_date,
            'R_date' => $request->R_date,
        ]);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cloth measurement updated successfully.',
                'data' => $clothM->load('customer.phone', 'customer.invoice'),
            ]);
        }

        // Redirect for web requests - check route name to determine redirect
        if (request()->route()->getName() === 'cloth.update') {
            return redirect()->route('cloth.show', $clothM->cm_id)
                ->with('success', 'Cloth measurement updated successfully.');
        }
        return redirect()->route('cloth-measurements.show', $clothM->cm_id)
            ->with('success', 'Cloth measurement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClothM $clothM)
    {
        $clothM->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cloth measurement deleted successfully.',
            ]);
        }

        // Redirect for web requests - check route name to determine redirect
        if (request()->route()->getName() === 'cloth.destroy') {
            return redirect()->route('cloth.index')
                ->with('success', 'Cloth measurement deleted successfully.');
        }
        return redirect()->route('cloth-measurements.index')
            ->with('success', 'Cloth measurement deleted successfully.');
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

        return view('cloth.print', compact('cloths', 'invoice', 'totalRate', 'totalPaid', 'totalRemain', 'invoiceId'));
    }

    /**
     * Print size for individual cloth measurement
     */
    public function printSize($clothId)
    {
        $cloth = ClothM::with(['customer.phone', 'customer.invoice'])->find($clothId);
        
        if (!$cloth) {
            return redirect()->back()->withErrors(['error' => 'Cloth measurement not found.']);
        }

        return view('cloth.sizePrint', compact('cloth'));
    }
}
