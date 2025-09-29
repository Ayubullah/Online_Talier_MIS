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
     * Search for assignments by cloth ID or vest ID
     */
    public function search(Request $request)
    {
        $request->validate([
            'search_id' => 'required|string'
        ]);

        $searchId = $request->search_id;
        
        // Search in both cloth and vest assignments
        $assignments = ClothAssignment::with(['clothMeasurement.customer', 'vestMeasurement.customer', 'employee'])
            ->where(function($query) use ($searchId) {
                $query->where('F_cm_id', $searchId)
                      ->orWhere('F_vm_id', $searchId)
                      ->orWhere('ca_id', $searchId);
            })
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

        $searchTerm = $searchId;

        return view('admin.status.index', compact('assignments', 'statusCounts', 'searchTerm'));
    }

    /**
     * Update cloth assignment status
     */
    public function updateClothStatus(Request $request, $id)
    {
        // dd($id);
        // Validate the status
        $request->validate([
            'status' => 'required|in:pending,complete'
        ]);

        // Find the cloth assignment by F_cm_id
        $assignment = ClothAssignment::where('F_cm_id', $id)->firstOrFail();
        
        // Update assignment status
        $assignment->status = $request->status;
        $assignment->completed_at = $request->status === 'complete' ? now() : null;
        $assignment->save();
        
        // Update cloth_m table
        ClothM::where('cm_id', $id)->update(['order_status' => $request->status]);
        
        // Redirect back with success message
        return redirect()->back()->with('success', 'Cloth status updated successfully!');
    }

    /**
     * Update vest assignment status
     */
    public function updateVestStatus(Request $request, $id)
    {

        // dd($id);
        // Validate the status
        $request->validate([
            'status' => 'required|in:pending,complete'
        ]);

        // Find the vest assignment by F_vm_id
        $assignment = ClothAssignment::where('F_vm_id', $id)->firstOrFail();
        
        // Update assignment status
        $assignment->status = $request->status;
        $assignment->completed_at = $request->status === 'complete' ? now() : null;
        $assignment->save();
        
        // Update vest_m table
        VestM::where('V_M_ID', $id)->update(['Status' => $request->status]);
        
        // Redirect back with success message
        return redirect()->back()->with('success', 'Vest status updated successfully!');
    }
}
