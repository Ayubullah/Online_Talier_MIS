<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $primaryKey = 'emp_id';
    public $timestamps = true;

    protected $fillable = [
        'emp_name',
        'role',
        'type',
        'cutter_s_rate',
        'cutter_l_rate',
        'salaye_s_rate',
        'salaye_l_rate',
        'F_user_id',
    ];

    protected $casts = [
        'cutter_s_rate' => 'decimal:2',
        'cutter_l_rate' => 'decimal:2',
        'salaye_s_rate' => 'decimal:2',
        'salaye_l_rate' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user associated with this employee.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'F_user_id', 'id');
    }

    /**
     * Get the cloth assignments for this employee.
     */
    public function clothAssignments()
    {
        return $this->hasMany(ClothAssignment::class, 'F_emp_id', 'emp_id');
    }

    /**
     * Get the payments for this employee.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'F_emp_id', 'emp_id');
    }

    /**
     * Check if employee has a user account
     */
    public function hasUserAccount()
    {
        return !is_null($this->user_id);
    }

    /**
     * Get available roles
     */
    public static function getAvailableRoles()
    {
        return ['cutter', 'salaye'];
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayAttribute()
    {
        $roles = [
            'cutter' => 'Cutter',
            'salaye' => 'Salaye',
        ];

        return $roles[$this->role] ?? $this->role;
    }

    /**
     * Get the appropriate rate based on role and work type
     */
    public function getEffectiveRate($workType = null)
    {
        // For cutter roles, return specific rates if available
        if ($this->role === 'cutter') {
            if ($workType === 's' && $this->cutter_s_rate) {
                return $this->cutter_s_rate;
            }
            if ($workType === 'l' && $this->cutter_l_rate) {
                return $this->cutter_l_rate;
            }
            // Return any available cutter rate as fallback
            return $this->cutter_s_rate ?: $this->cutter_l_rate;
        }
        
        // For salaye roles, return specific rates if available
        if ($this->role === 'salaye') {
            if ($workType === 's' && $this->salaye_s_rate) {
                return $this->salaye_s_rate;
            }
            if ($workType === 'l' && $this->salaye_l_rate) {
                return $this->salaye_l_rate;
            }
            // Return any available salaye rate as fallback
            return $this->salaye_s_rate ?: $this->salaye_l_rate;
        }
        
        // No rate available
        return 0;
    }

    /**
     * Get cutting rates for cutter employees
     */
    public function getCuttingRatesAttribute()
    {
        if ($this->role === 'cutter') {
            return [
                'small' => $this->cutter_s_rate ?: 0,
                'large' => $this->cutter_l_rate ?: 0,
            ];
        }
        
        return null;
    }

    /**
     * Get salaye rates for salaye employees
     */
    public function getSalayeRatesAttribute()
    {
        if ($this->role === 'salaye') {
            return [
                'small' => $this->salaye_s_rate ?: 0,
                'large' => $this->salaye_l_rate ?: 0,
            ];
        }
        
        return null;
    }

    /**
     * Check if employee is a cutter
     */
    public function isCutter()
    {
        return $this->role === 'cutter';
    }

    /**
     * Check if employee is a salary worker
     */
    public function isSalaryWorker()
    {
        return $this->role === 'salaye';
    }

    /**
     * Get available types
     */
    public static function getAvailableTypes()
    {
        return ['cloth', 'vest'];
    }

    /**
     * Get type display name
     */
    public function getTypeDisplayAttribute()
    {
        if (!$this->type) {
            return null;
        }

        $types = [
            'cloth' => 'Cloth',
            'vest' => 'Vest',
        ];

        return $types[$this->type] ?? $this->type;
    }

    /**
     * Check if employee works with cloth
     */
    public function isClothType()
    {
        return $this->type === 'cloth';
    }

    /**
     * Check if employee works with vest
     */
    public function isVestType()
    {
        return $this->type === 'vest';
    }
}
