<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'pay_id';
    public $timestamps = true;

    protected $fillable = [
        'F_emp_id',
        'F_inc_id',
        'F_phone_id',
        'amount',
        'method',
        'note',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];



    /**
     * Get the employee associated with this payment.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'F_emp_id', 'emp_id');
    }

    /**
     * Get the phone associated with this payment.
     */
    public function phone()
    {
        return $this->belongsTo(Phone::class, 'F_phone_id', 'pho_id');
    }
    
    /**
     * Get the payment recipient (employee).
     */
    public function getPaymentRecipientAttribute()
    {
        return $this->employee;
    }



    /**
     * Get available payment methods
     */
    public static function getAvailablePaymentMethods()
    {
        return ['cash', 'card', 'bank'];
    }









    /**
     * Get payment method display name
     */
    public function getPaymentMethodDisplayAttribute()
    {
        $methods = [
            'cash' => 'Cash',
            'card' => 'Card',
            'bank' => 'Bank Transfer',
        ];

        return $methods[$this->method] ?? $this->method;
    }
}
