<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $primaryKey = 'cus_id';
    public $timestamps = true;

    protected $fillable = [
        'cus_name',
        'F_pho_id',
        'F_inv_id',
    ];

    /**
     * Get the phone associated with this customer.
     */
    public function phone()
    {
        return $this->belongsTo(Phone::class, 'F_pho_id', 'pho_id');
    }

    /**
     * Get the invoice associated with this customer.
     */
    public function invoice()
    {
        return $this->belongsTo(InvoiceTb::class, 'F_inv_id', 'inc_id');
    }

    /**
     * Get the cloth measurements for this customer.
     */
    public function clothMeasurements()
    {
        return $this->hasMany(ClothM::class, 'F_cus_id', 'cus_id');
    }

    /**
     * Get the vest measurements for this customer.
     */
    public function vestMeasurements()
    {
        return $this->hasMany(VestM::class, 'F_cus_id', 'cus_id');
    }

    /**
     * Get the customer payments for this customer.
     */
    public function customerPayments()
    {
        return $this->hasMany(CustomerPayment::class, 'customer_id', 'cus_id');
    }

    /**
     * Get all orders (cloth + vest) for this customer.
     */
    public function getAllOrdersAttribute()
    {
        $clothOrders = $this->clothMeasurements()->get()->map(function ($order) {
            $order->order_type = 'cloth';
            return $order;
        });

        $vestOrders = $this->vestMeasurements()->get()->map(function ($order) {
            $order->order_type = 'vest';
            return $order;
        });

        return $clothOrders->concat($vestOrders)->sortByDesc('created_at');
    }

    /**
     * Get total amount owed by customer (cloth_rate + vest_rate - payments)
     */
    public function getTotalOwedAttribute()
    {
        $totalClothRate = $this->clothMeasurements()->sum('cloth_rate');
        $totalVestRate = $this->vestMeasurements()->sum('vest_rate');
        $totalPaid = $this->customerPayments()->sum('amount');
        
        return ($totalClothRate + $totalVestRate) - $totalPaid;
    }

    /**
     * Get total amount paid by customer
     */
    public function getTotalPaidAttribute()
    {
        return $this->customerPayments()->sum('amount');
    }

    /**
     * Get total order value (cloth_rate + vest_rate)
     */
    public function getTotalOrderValueAttribute()
    {
        $totalClothRate = $this->clothMeasurements()->sum('cloth_rate');
        $totalVestRate = $this->vestMeasurements()->sum('vest_rate');
        
        return $totalClothRate + $totalVestRate;
    }
}
