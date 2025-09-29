<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPaymentController extends Controller
{
    /**
     * Display a listing of customer payments.
     */
    public function index(Request $request)
    {
        $query = CustomerPayment::with('customer');

        // Search by customer phone number
        if ($request->filled('phone_number')) {
            $query->whereHas('customer.phone', function ($q) use ($request) {
                $q->where('pho_no', 'like', '%' . $request->phone_number . '%');
            });
        }

        // Search by customer name
        if ($request->filled('customer_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('cus_name', 'like', '%' . $request->customer_name . '%');
            });
        }

        $payments = $query->orderBy('payment_date', 'desc')->paginate(15);

        return view('customer-payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new customer payment.
     */
    public function create(Request $request)
    {
        $customer = null;
        
        // If customer_id is provided, load the customer
        if ($request->filled('customer_id')) {
            $customer = Customer::with(['phone', 'clothMeasurements', 'vestMeasurements', 'customerPayments'])
                              ->findOrFail($request->customer_id);
        }

        return view('customer-payments.create', compact('customer'));
    }

    /**
     * Store a newly created customer payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customer,cus_id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,card',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'reference_number' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $payment = CustomerPayment::create([
                'customer_id' => $request->customer_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
                'notes' => $request->notes,
                'reference_number' => $request->reference_number,
            ]);

            DB::commit();

            return redirect()->route('customers.show', $request->customer_id)
                           ->with('success', 'Payment recorded successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                        ->with('error', 'Failed to record payment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified customer payment.
     */
    public function show(CustomerPayment $customerPayment)
    {
        $customerPayment->load('customer.phone');
        return view('customer-payments.show', compact('customerPayment'));
    }

    /**
     * Show the form for editing the specified customer payment.
     */
    public function edit(CustomerPayment $customerPayment)
    {
        $customerPayment->load('customer');
        return view('customer-payments.edit', compact('customerPayment'));
    }

    /**
     * Update the specified customer payment.
     */
    public function update(Request $request, CustomerPayment $customerPayment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,card',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'reference_number' => 'nullable|string|max:100',
        ]);

        try {
            $customerPayment->update($request->all());

            return redirect()->route('customers.show', $customerPayment->customer_id)
                           ->with('success', 'Payment updated successfully!');

        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Failed to update payment: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified customer payment.
     */
    public function destroy(CustomerPayment $customerPayment)
    {
        try {
            $customerId = $customerPayment->customer_id;
            $customerPayment->delete();

            return redirect()->route('customers.show', $customerId)
                           ->with('success', 'Payment deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete payment: ' . $e->getMessage());
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
}
