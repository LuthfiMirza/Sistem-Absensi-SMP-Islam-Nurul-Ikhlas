<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Permission::with(['user', 'attendance']);
        
        // If user is not operator, only show their own permissions
        if (!auth()->user()->isOperator()) {
            $query->where('user_id', auth()->id());
        }
        
        $permissions = $query->latest()->paginate(10);

        return view('permissions.index', [
            'title' => 'Data Izin',
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attendances = Attendance::latest()->get();
        
        return view('permissions.create', [
            'title' => 'Ajukan Izin',
            'attendances' => $attendances
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if user already has permission for this date
        $existingPermission = Permission::where('user_id', auth()->id())
            ->where('permission_date', $request->permission_date)
            ->first();

        if ($existingPermission) {
            return redirect()->back()
                ->withErrors(['permission_date' => 'Anda sudah mengajukan izin untuk tanggal ini.']);
        }

        $rules = [
            'attendance_id' => 'required|exists:attendances,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:same_day,leave',
            'permission_date' => 'required|date'
        ];

        if ($request->type === 'same_day') {
            $rules['late_arrival_time'] = 'nullable|date_format:H:i';
            $rules['early_departure_time'] = 'nullable|date_format:H:i';
        } else {
            $rules['leave_start_date'] = 'required|date';
            $rules['leave_end_date'] = 'required|date|after_or_equal:leave_start_date';
            $rules['medical_certificate'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $rules['proof_document'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';

        $request->validate($rules);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        // Handle file uploads
        if ($request->hasFile('medical_certificate')) {
            $data['medical_certificate'] = $request->file('medical_certificate')
                ->store('medical_certificates', 'public');
        }

        if ($request->hasFile('proof_document')) {
            $data['proof_document'] = $request->file('proof_document')
                ->store('proof_documents', 'public');
        }

        Permission::create($data);

        return redirect()->route('permissions.index')
            ->with('success', 'Izin berhasil diajukan');
    }

    /**
     * Display the specified resource.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('permissions.show', [
            'title' => 'Detail Izin',
            'permission' => $permission
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        // Only allow editing if user is the owner and permission is still pending
        if ($permission->user_id !== auth()->id() || !$permission->isPending()) {
            abort(403);
        }

        $attendances = Attendance::latest()->get();
        
        return view('permissions.edit', [
            'title' => 'Edit Izin',
            'permission' => $permission,
            'attendances' => $attendances
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        // Only allow updating if user is the owner and permission is still pending
        if ($permission->user_id !== auth()->id() || !$permission->isPending()) {
            abort(403);
        }

        $rules = [
            'attendance_id' => 'required|exists:attendances,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:same_day,leave',
            'permission_date' => 'required|date'
        ];

        if ($request->type === 'same_day') {
            $rules['late_arrival_time'] = 'nullable|date_format:H:i';
            $rules['early_departure_time'] = 'nullable|date_format:H:i';
        } else {
            $rules['leave_start_date'] = 'required|date';
            $rules['leave_end_date'] = 'required|date|after_or_equal:leave_start_date';
            $rules['medical_certificate'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $rules['proof_document'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';

        $request->validate($rules);

        $data = $request->all();

        // Handle file uploads
        if ($request->hasFile('medical_certificate')) {
            if ($permission->medical_certificate) {
                Storage::disk('public')->delete($permission->medical_certificate);
            }
            $data['medical_certificate'] = $request->file('medical_certificate')
                ->store('medical_certificates', 'public');
        }

        if ($request->hasFile('proof_document')) {
            if ($permission->proof_document) {
                Storage::disk('public')->delete($permission->proof_document);
            }
            $data['proof_document'] = $request->file('proof_document')
                ->store('proof_documents', 'public');
        }

        $permission->update($data);

        return redirect()->route('permissions.index')
            ->with('success', 'Izin berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        // Only allow deletion if user is the owner and permission is still pending
        if ($permission->user_id !== auth()->id() || !$permission->isPending()) {
            abort(403);
        }

        // Delete uploaded files
        if ($permission->medical_certificate) {
            Storage::disk('public')->delete($permission->medical_certificate);
        }
        if ($permission->proof_document) {
            Storage::disk('public')->delete($permission->proof_document);
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Izin berhasil dihapus');
    }

    /**
     * Update permission status - simplified workflow
     */
    public function updateStatus(Request $request, Permission $permission)
    {
        // Add debugging
        \Log::info('updateStatus called', [
            'permission_id' => $permission->id,
            'request_data' => $request->all(),
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role->name ?? 'no role'
        ]);

        $request->validate([
            'action' => 'required|in:accept,reject',
            'rejection_reason' => 'required_if:action,reject|string'
        ]);

        // Only allow status update if permission is still pending
        if (!$permission->isPending()) {
            \Log::warning('Permission not pending', [
                'permission_id' => $permission->id,
                'current_status' => $permission->status
            ]);
            return redirect()->back()
                ->withErrors(['status' => 'Izin sudah diproses dan tidak dapat diubah lagi']);
        }

        $action = $request->action;
        $message = '';

        switch ($action) {
            case 'accept':
                $permission->update(['status' => 'accepted']);
                $message = 'Izin berhasil diterima';
                \Log::info('Permission accepted', ['permission_id' => $permission->id]);
                break;
            
            case 'reject':
                $permission->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason
                ]);
                $message = 'Izin berhasil ditolak';
                \Log::info('Permission rejected', [
                    'permission_id' => $permission->id,
                    'reason' => $request->rejection_reason
                ]);
                break;
        }
        
        return redirect()->back()
            ->with('success', $message);
    }
}
