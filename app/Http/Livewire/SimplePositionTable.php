<?php

namespace App\Http\Livewire;

use App\Models\Position;
use Livewire\Component;
use Livewire\WithPagination;

class SimplePositionTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedPositions = [];
    public $selectAll = false;
    public $filterType = '';

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
            $this->selectedPositions = $this->getPositions()->pluck('id')->toArray();
        } else {
            $this->selectedPositions = [];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedPositions)) {
            session()->flash('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
            return;
        }

        try {
            Position::whereIn('id', $this->selectedPositions)->delete();
            $this->selectedPositions = [];
            $this->selectAll = false;
            session()->flash('success', 'Data Divisi/Mata Pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Data gagal dihapus, kemungkinan ada data lain yang menggunakan data tersebut.');
        }
    }

    public function getPositions()
    {
        return Position::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $positions = $this->getPositions()->paginate($this->perPage);

        return view('livewire.simple-position-table', [
            'positions' => $positions
        ]);
    }
}