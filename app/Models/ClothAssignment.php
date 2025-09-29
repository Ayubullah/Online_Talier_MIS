<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClothAssignment extends Model
{
    use HasFactory;

    protected $table = 'cloth_assignment';
    protected $primaryKey = 'ca_id';
    public $timestamps = true;

    protected $fillable = [
        'F_cm_id',
        'F_vm_id',
        'F_emp_id',
        'work_type',
        'qty',
        'rate_at_assign',
        'status',
        'assigned_at',
        'completed_at',
    ];

    protected $casts = [
        'rate_at_assign' => 'decimal:2',
        'qty' => 'integer',
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the cloth measurement associated with this assignment.
     */
    public function clothMeasurement()
    {
        return $this->belongsTo(ClothM::class, 'F_cm_id', 'cm_id');
    }

    /**
     * Get the vest measurement associated with this assignment.
     */
    public function vestMeasurement()
    {
        return $this->belongsTo(VestM::class, 'F_vm_id', 'V_M_ID');
    }

    /**
     * Get the employee associated with this assignment.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'F_emp_id', 'emp_id');
    }

    /**
     * Get the assignable item (cloth or vest).
     */
    public function getAssignableItemAttribute()
    {
        if ($this->F_cm_id) {
            return $this->clothMeasurement;
        }

        if ($this->F_vm_id) {
            return $this->vestMeasurement;
        }

        return null;
    }

    /**
     * Get the assignment type.
     */
    public function getAssignmentTypeAttribute()
    {
        if ($this->F_cm_id) {
            return 'cloth';
        }

        if ($this->F_vm_id) {
            return 'vest';
        }

        return 'unknown';
    }

    /**
     * Get available work types
     */
    public static function getAvailableWorkTypes()
    {
        return ['cutting', 'salaye'];
    }

    /**
     * Get available statuses
     */
    public static function getAvailableStatuses()
    {
        return ['pending', 'complete'];
    }

    /**
     * Get work type display name
     */
    public function getWorkTypeDisplayAttribute()
    {
        $workTypes = [
            'cutting' => 'Cutting',
            'salaye' => 'Salaye',
        ];

        return $workTypes[$this->work_type] ?? $this->work_type;
    }

    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'pending' => 'Pending',
            'complete' => 'Complete',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Calculate total amount for this assignment
     */
    public function getTotalAmountAttribute()
    {
        return $this->qty * $this->rate_at_assign;
    }

    /**
     * Mark assignment as complete
     */
    public function markAsComplete()
    {
        $this->update([
            'status' => 'complete',
            'completed_at' => now(),
        ]);
    }
}
