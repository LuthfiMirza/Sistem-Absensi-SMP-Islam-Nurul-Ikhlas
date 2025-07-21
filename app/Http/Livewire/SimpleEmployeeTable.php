<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Role;
use App\Models\Position;
use Livewire\Component;
use Livewire\WithPagination;

class SimpleEmployeeTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedUsers = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedUsers = $this->getUsers()->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
            return;
        }

        if (in_array(auth()->user()->id, $this->selectedUsers)) {
            session()->flash('error', 'Anda tidak diizinkan untuk menghapus data yang sedang anda gunakan untuk login.');
            return;
        }

        try {
            User::whereIn('id', $this->selectedUsers)->delete();
            $this->selectedUsers = [];
            $this->selectAll = false;
            session()->flash('success', 'Data Guru/Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Data gagal dihapus, kemungkinan ada data lain yang menggunakan data tersebut.');
        }
    }

    public function getUsers()
    {
        return User::with(['role', 'position'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhereHas('role', function ($role) {
                          $role->where('name', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('position', function ($position) {
                          $position->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $users = $this->getUsers()->paginate($this->perPage);

        return view('livewire.simple-employee-table', [
            'users' => $users,
            'roles' => Role::all(),
            'positions' => Position::all()
        ]);
    }
}