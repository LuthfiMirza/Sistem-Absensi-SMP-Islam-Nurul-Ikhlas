<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('perPage', 10);
        
        $users = User::with(['role', 'position'])
            ->whereHas('role', function ($query) {
                $query->whereIn('name', ['guru', 'karyawan']);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%')
                      ->orWhereHas('role', function ($role) use ($search) {
                          $role->where('name', 'like', '%' . $search . '%');
                      })
                      ->orWhereHas('position', function ($position) use ($search) {
                          $position->where('name', 'like', '%' . $search . '%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('employees.index', [
            "title" => "Pegawai",
            "users" => $users
        ]);
    }

    public function create()
    {
        $roles = Role::whereIn('name', ['guru', 'karyawan'])->get();
        $positions = Position::all();
        
        return view('employees.create', [
            "title" => "Tambah Data Pegawai",
            "roles" => $roles,
            "positions" => $positions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'position_id' => 'required|exists:positions,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'position_id' => $request->position_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('employees.index')->with('success', 'Data Pegawai berhasil ditambahkan.');
    }

    public function show(User $employee)
    {
        return view('employees.show', [
            "title" => "Detail Data Pegawai",
            "employee" => $employee
        ]);
    }

    public function edit($id = null)
    {
        // Handle both single edit and bulk edit
        if ($id) {
            // Single edit
            $employee = User::findOrFail($id);
            $roles = Role::whereIn('name', ['guru', 'karyawan'])->get();
            $positions = Position::all();
            
            return view('employees.edit-single', [
                "title" => "Edit Data Pegawai",
                "employee" => $employee,
                "roles" => $roles,
                "positions" => $positions
            ]);
        } else {
            // Bulk edit
            $ids = request('ids');
            if (!$ids)
                return redirect()->back();
            $ids = explode('-', $ids);

            $employees = User::query()
                ->whereIn('id', $ids)
                ->get();

            $roles = Role::whereIn('name', ['guru', 'karyawan'])->get();
            $positions = Position::all();

            return view('employees.edit', [
                "title" => "Edit Data Pegawai",
                "employees" => $employees,
                "roles" => $roles,
                "positions" => $positions
            ]);
        }
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($employee->id)],
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'position_id' => 'required|exists:positions,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'position_id' => $request->position_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $employee->update($updateData);

        return redirect()->route('employees.index')->with('success', 'Data Pegawai berhasil diperbarui.');
    }

    public function destroy(User $employee)
    {
        if ($employee->id === auth()->user()->id) {
            return redirect()->route('employees.index')->with('error', 'Anda tidak diizinkan untuk menghapus data yang sedang anda gunakan untuk login.');
        }

        try {
            $employee->delete();
            return redirect()->route('employees.index')->with('success', 'Data Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $selectedIds = explode(',', $request->selected_ids);
        
        if (empty($selectedIds)) {
            return redirect()->route('employees.index')->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        if (in_array(auth()->user()->id, $selectedIds)) {
            return redirect()->route('employees.index')->with('error', 'Anda tidak diizinkan untuk menghapus data yang sedang anda gunakan untuk login.');
        }

        try {
            $deletedCount = User::whereIn('id', $selectedIds)->delete();
            return redirect()->route('employees.index')->with('success', $deletedCount . ' Data Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}