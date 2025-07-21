<?php

namespace App\Http\Livewire;

use App\Models\Holiday;
use Livewire\Component;
use Livewire\WithPagination;

class SimpleHolidayTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'holiday_date';
    public $sortDirection = 'desc';
    public $selectedHolidays = [];
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
            $this->selectedHolidays = $this->getHolidays()->pluck('id')->toArray();
        } else {
            $this->selectedHolidays = [];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedHolidays)) {
            session()->flash('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
            return;
        }

        try {
            Holiday::whereIn('id', $this->selectedHolidays)->delete();
            $this->selectedHolidays = [];
            $this->selectAll = false;
            session()->flash('success', 'Data Hari Libur berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Data gagal dihapus.');
        }
    }

    public function getHolidays()
    {
        return Holiday::query()
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
        $holidays = $this->getHolidays()->paginate($this->perPage);

        return view('livewire.simple-holiday-table', [
            'holidays' => $holidays
        ]);
    }
}