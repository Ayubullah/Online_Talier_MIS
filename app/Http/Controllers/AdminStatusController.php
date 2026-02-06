<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClothAssignment;
use App\Models\ClothM;
use App\Models\VestM;
use Illuminate\Support\Facades\DB;

class AdminStatusController extends Controller
{
    /**
     * Display the admin status management page
     */
    public function index()
    {
        // Get all assignments with pagination
        $assignments = ClothAssignment::with(['clothMeasurement.customer', 'vestMeasurement.customer', 'employee'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get status counts
        $statusCounts = [
            'total_assignments' => ClothAssignment::count(),
            'completed_assignments' => ClothAssignment::where('status', 'complete')->count(),
            'pending_assignments' => ClothAssignment::where('status', 'pending')->count(),
            'cloth_assignments' => ClothAssignment::whereNotNull('F_cm_id')->count(),
            'vest_assignments' => ClothAssignment::whereNotNull('F_vm_id')->count(),
            'cloth_completed' => ClothAssignment::where('status', 'complete')->whereNotNull('F_cm_id')->count(),
            'cloth_pending' => ClothAssignment::where('status', 'pending')->whereNotNull('F_cm_id')->count(),
            'vest_completed' => ClothAssignment::where('status', 'complete')->whereNotNull('F_vm_id')->count(),
            'vest_pending' => ClothAssignment::where('status', 'pending')->whereNotNull('F_vm_id')->count(),
            
            // Total records from cloth_m and vest_m tables
            'total_cloth_records' => ClothM::count(),
            'total_vest_records' => VestM::count(),
            'total_records' => ClothM::count() + VestM::count(),
            
            // Cloth_m table status counts
            'cloth_m_completed' => ClothM::where('order_status', 'complete')->count(),
            'cloth_m_pending' => ClothM::where('order_status', 'pending')->count(),
            
            // Vest_m table status counts
            'vest_m_completed' => VestM::where('Status', 'complete')->count(),
            'vest_m_pending' => VestM::where('Status', 'pending')->count(),
        ];

        return view('admin.status.index', compact('assignments', 'statusCounts'));
    }


    /**
     * Update assignment status by assignment ID
     */
    public function updateAssignmentStatus(Request $request, ClothAssignment $assignment)
    {
        // Validate the status
        $request->validate([
            'status' => 'required|in:pending,complete'
        ]);

        // Update assignment status
        $assignment->status = $request->status;
        $assignment->completed_at = $request->status === 'complete' ? now() : null;
        $assignment->save();

        // Update corresponding measurement table
        if ($assignment->F_cm_id) {
            // Update cloth_m table
            ClothM::where('cm_id', $assignment->F_cm_id)->update(['order_status' => $request->status]);
            $message = 'Cloth assignment status updated successfully!';
        } elseif ($assignment->F_vm_id) {
            // Update vest_m table
            VestM::where('V_M_ID', $assignment->F_vm_id)->update(['Status' => $request->status]);
            $message = 'Vest assignment status updated successfully!';
        } else {
            $message = 'Assignment status updated successfully!';
        }

        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'assignment' => $assignment
            ]);
        }

        // Redirect back with success message for regular requests
        return redirect()->back()->with('success', $message);
    }
}
