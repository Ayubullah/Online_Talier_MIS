<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $table = 'customer_payments';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'amount',
        'payment_method',
        'payment_date',
        'notes',
        'reference_number',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns this payment.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'cus_id');
    }

    /**
     * Get available payment methods
     */
    public static function getAvailablePaymentMethods()
    {
        return ['cash', 'bank_transfer', 'mobile_money', 'card'];
    }

    /**
     * Get payment method display name
     */
    public function getPaymentMethodDisplayAttribute()
    {
        $methods = [
            'cash' => 'Cash',
            'bank_transfer' => 'Bank Transfer',
            'mobile_money' => 'Mobile Money',
            'card' => 'Card',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }
}
