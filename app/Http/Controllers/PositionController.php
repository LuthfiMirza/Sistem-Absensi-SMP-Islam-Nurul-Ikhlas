<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $filterType = $request->get('filterType');
        $perPage = $request->get('perPage', 10);
        
        $positions = Position::with('users')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($filterType, function ($query) use ($filterType) {
                $query->where('type', $filterType);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('positions.index', [
            "title" => "Divisi Pegawai",
            "positions" => $positions
        ]);
    }

    public function create()
    {
        return view('positions.create', [
            "title" => "Tambah Divisi Pegawai"
        ]);
    }

    public function store(Request $request)
    {
        // Validate at least the first position
        $request->validate([
            'positions.0.name' => 'required|string|max:255',
            'positions.0.type' => 'required|in:guru,karyawan'
        ], [
            'positions.0.name.required' => 'Setidaknya input Data Pegawai pertama wajib diisi.',
            'positions.0.type.required' => 'Kategori wajib dipilih.'
        ]);

        // Filter out empty positions
        $positions = array_filter($request->positions, function ($position) {
            return !empty(trim($position['name']));
        });

        if (empty($positions)) {
            return redirect()->back()->with('error', 'Minimal satu data pegawai harus diisi.');
        }

        // Create positions
        foreach ($positions as $position) {
            Position::create([
                'name' => trim($position['name']),
                'type' => $position['type']
            ]);
        }

        $count = count($positions);
        $message = $count === 1 ? 'Data Divisi Pegawai berhasil ditambahkan.' : "{$count} Data Divisi Pegawai berhasil ditambahkan.";

        return redirect()->route('positions.index')->with('success', $message);
    }

    public function show(Position $position)
    {
        return view('positions.show', [
            "title" => "Detail Divisi Pegawai",
            "position" => $position
        ]);
    }

    public function edit(Position $position)
    {
        return view('positions.edit-single', [
            "title" => "Edit Divisi Pegawai",
            "position" => $position
        ]);
    }

    public function bulkEdit()
    {
        $ids = request('ids');
        if (!$ids)
            return redirect()->back();
        $ids = explode('-', $ids);

        $positions = Position::query()->whereIn('id', $ids)->get();

        return view('positions.edit', [
            "title" => "Edit Data Divisi Pegawai",
            "positions" => $positions
        ]);
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:guru,karyawan'
        ]);

        $position->update([
            'name' => $request->name,
            'type' => $request->type
        ]);

        return redirect()->route('positions.index')->with('success', 'Data Divisi Pegawai berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        // Check if position has users
        $userCount = $position->users()->count();
        
        if ($userCount > 0) {
            $userNames = $position->users()->pluck('name')->take(3)->toArray();
            $userList = implode(', ', $userNames);
            if ($userCount > 3) {
                $userList .= ' dan ' . ($userCount - 3) . ' lainnya';
            }
            
            return redirect()->route('positions.index')
                ->with('error', "Tidak dapat menghapus divisi '{$position->name}' karena masih digunakan oleh {$userCount} pegawai: {$userList}. Hapus atau pindahkan pegawai terlebih dahulu.");
        }

        try {
            $position->delete();
            return redirect()->route('positions.index')->with('success', 'Data Divisi Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('positions.index')->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $selectedIds = explode(',', $request->selected_ids);
        
        if (empty($selectedIds)) {
            return redirect()->route('positions.index')->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        // Check if any positions have users
        $positionsWithUsers = Position::whereIn('id', $selectedIds)
            ->withCount('users')
            ->having('users_count', '>', 0)
            ->get();

        if ($positionsWithUsers->count() > 0) {
            $positionNames = $positionsWithUsers->pluck('name')->take(3)->toArray();
            $positionList = implode(', ', $positionNames);
            if ($positionsWithUsers->count() > 3) {
                $positionList .= ' dan ' . ($positionsWithUsers->count() - 3) . ' lainnya';
            }
            
            return redirect()->route('positions.index')
                ->with('error', "Tidak dapat menghapus divisi: {$positionList} karena masih digunakan oleh pegawai. Hapus atau pindahkan pegawai terlebih dahulu.");
        }

        try {
            $deletedCount = Position::whereIn('id', $selectedIds)->delete();
            return redirect()->route('positions.index')->with('success', $deletedCount . ' Data Divisi Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('positions.index')->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}