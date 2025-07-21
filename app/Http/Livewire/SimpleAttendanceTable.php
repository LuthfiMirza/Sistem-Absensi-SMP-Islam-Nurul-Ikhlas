<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use Livewire\Component;
use Livewire\WithPagination;

class SimpleAttendanceTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedAttendances = [];
    public $selectAll = false;
    public $filterStatus = '';

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
            $this->selectedAttendances = $this->getAttendances()->pluck('id')->toArray();
        } else {
            $this->selectedAttendances = [];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedAttendances)) {
            session()->flash('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
            return;
        }

        try {
            Attendance::whereIn('id', $this->selectedAttendances)->delete();
            $this->selectedAttendances = [];
            $this->selectAll = false;
            session()->flash('success', 'Data Absensi berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Data gagal dihapus, kemungkinan ada data lain yang menggunakan data tersebut.');
        }
    }

    public function getAttendances()
    {
        return Attendance::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $attendances = $this->getAttendances()->paginate($this->perPage);

        return view('livewire.simple-attendance-table', [
            'attendances' => $attendances
        ]);
    }
}