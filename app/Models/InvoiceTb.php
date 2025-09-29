<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTb extends Model
{
    use HasFactory;

    protected $table = 'invoice_tb';
    protected $primaryKey = 'inc_id';
    public $timestamps = true;

    protected $fillable = [
        'inc_date',
        'total_amt',
        'status',
    ];

    protected $casts = [
        'inc_date' => 'datetime',
        'total_amt' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customers for this invoice.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'F_inv_id', 'inc_id');
    }

    /**
     * Get the payments for this invoice.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'F_inc_id', 'inc_id');
    }

    /**
     * Get available statuses
     */
    public static function getAvailableStatuses()
    {
        return ['unpaid', 'partial', 'paid'];
    }

    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'unpaid' => 'Unpaid',
            'partial' => 'Partially Paid',
            'paid' => 'Fully Paid',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get total paid amount
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }

    /**
     * Get remaining amount
     */
    public function getRemainingAmountAttribute()
    {
        return $this->total_amt - $this->total_paid;
    }
}
