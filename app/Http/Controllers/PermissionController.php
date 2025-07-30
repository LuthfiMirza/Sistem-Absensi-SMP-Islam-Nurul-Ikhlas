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
    public function index(Request $request)
    {
        $query = Permission::with(['user', 'user.position', 'attendance']);
        
        // If user is not operator, only show their own permissions
        if (!auth()->user()->isOperator()) {
            $query->where('user_id', auth()->id());
        }
        
        // Apply filters for operators
        if (auth()->user()->isOperator()) {
            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            // Filter by type
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }
            
            // Filter by date range
            if ($request->filled('date_from')) {
                $query->whereDate('permission_date', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('permission_date', '<=', $request->date_to);
            }
            
            // Search by user name
            if ($request->filled('search')) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            }
        }
        
        $permissions = $query->latest()->paginate(15);

        return view('permissions.index', [
            'title' => auth()->user()->isOperator() ? 'Data Izin Karyawan' : 'Izin Saya',
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
        // Check authorization
        if (auth()->user()->isOperator()) {
            // Operators can delete any permission
            $this->deletePermissionFiles($permission);
            $permission->delete();
            
            return redirect()->route('permissions.index')
                ->with('success', "Izin atas nama \"{$permission->user->name}\" berhasil dihapus");
        } else {
            // Users can only delete their own pending permissions
            if ($permission->user_id !== auth()->id() || !$permission->isPending()) {
                abort(403, 'Anda tidak memiliki izin untuk menghapus data ini');
            }
            
            $this->deletePermissionFiles($permission);
            $permission->delete();
            
            return redirect()->route('my-permissions.index')
                ->with('success', 'Izin berhasil dihapus');
        }
    }
    
    /**
     * Delete permission related files
     *
     * @param  Permission  $permission
     * @return void
     */
    private function deletePermissionFiles(Permission $permission)
    {
        // Delete uploaded files
        if ($permission->medical_certificate) {
            Storage::disk('public')->delete($permission->medical_certificate);
        }
        if ($permission->proof_document) {
            Storage::disk('public')->delete($permission->proof_document);
        }
    }
}