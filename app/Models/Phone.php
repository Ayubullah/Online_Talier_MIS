<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Phone extends Model
{
    use HasFactory;

    protected $table = 'phone';
    protected $primaryKey = 'pho_id';
    public $timestamps = true;

    protected $fillable = [
        'pho_no',
    ];

    /**
     * Get the customers that use this phone.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'F_pho_id', 'pho_id');
    }

    /**
     * Get the payments for this phone.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'F_phone_id', 'pho_id');
    }
}
