<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VestM extends Model
{
    use HasFactory;

    protected $table = 'vest_m';
    protected $primaryKey = 'V_M_ID';
    public $timestamps = false; // Using custom created_at field

    protected $fillable = [
        'F_cus_id',
        'size',
        'vest_rate',
        'Height',
        'Shoulder',
        'Armpit',
        'Waist',
        'Shana',
        'Kalar',
        'Daman',
        'NawaWaskat',
        'Vest_Type',
        'Status',
        'O_date',
        'R_date',
    ];

    protected $casts = [
        'vest_rate' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'O_date' => 'date',
        'R_date' => 'date',
    ];

    /**
     * Get the customer that owns this vest measurement.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'F_cus_id', 'cus_id');
    }

    /**
     * Get the cloth assignments for this vest measurement.
     */
    public function clothAssignments()
    {
        return $this->hasMany(ClothAssignment::class, 'F_vm_id', 'V_M_ID');
    }

    /**
     * Get available sizes
     */
    public static function getAvailableSizes()
    {
        return ['S', 'L'];
    }

    /**
     * Get size display name
     */
    public function getSizeDisplayAttribute()
    {
        $sizes = [
            'S' => 'Small',
            'L' => 'Large',
        ];

        return $sizes[$this->size] ?? $this->size;
    }
}
