<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use Livewire\Component;
use Livewire\WithFileUploads;

class PermissionForm extends Component
{
    use WithFileUploads;

    public $permission;
    public $attendanceId;
    public $type = 'same_day';
    public $medical_certificate;
    public $proof_document;
    public $late_arrival_time;
    public $early_departure_time;
    public $leave_start_date;
    public $leave_end_date;

    protected $rules = [
        'permission.title' => 'required|string|min:6',
        'permission.description' => 'required|string|max:500',
        'type' => 'required|in:same_day,leave',
        'medical_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'proof_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'late_arrival_time' => 'nullable|date_format:H:i',
        'early_departure_time' => 'nullable|date_format:H:i',
        'leave_start_date' => 'nullable|date',
        'leave_end_date' => 'nullable|date|after_or_equal:leave_start_date',
    ];

    protected $messages = [
        'permission.title.required' => 'Judul izin harus diisi',
        'permission.title.min' => 'Judul izin minimal 6 karakter',
        'permission.description.required' => 'Keterangan izin harus diisi',
        'permission.description.max' => 'Keterangan izin maksimal 500 karakter',
        'medical_certificate.mimes' => 'Surat dokter harus berformat PDF, JPG, JPEG, atau PNG',
        'medical_certificate.max' => 'Ukuran surat dokter maksimal 2MB',
        'proof_document.mimes' => 'Dokumen pendukung harus berformat PDF, JPG, JPEG, atau PNG',
        'proof_document.max' => 'Ukuran dokumen pendukung maksimal 2MB',
        'leave_end_date.after_or_equal' => 'Tanggal selesai cuti harus setelah atau sama dengan tanggal mulai',
    ];

    public function save()
    {
        // Check if user already has permission for today
        $existingPermission = Permission::where('user_id', auth()->id())
            ->where('permission_date', now()->toDateString())
            ->first();

        if ($existingPermission) {
            session()->flash('error', 'Anda sudah mengajukan izin untuk hari ini.');
            return;
        }

        $this->validate();

        $data = [
            "user_id" => auth()->user()->id,
            "attendance_id" => $this->attendanceId,
            "title" => $this->permission['title'],
            "description" => $this->permission['description'],
            "permission_date" => now()->toDateString(),
            "type" => $this->type,
        ];

        // Handle same day permission
        if ($this->type === 'same_day') {
            $data['late_arrival_time'] = $this->late_arrival_time;
            $data['early_departure_time'] = $this->early_departure_time;
        }

        // Handle leave permission
        if ($this->type === 'leave') {
            $data['leave_start_date'] = $this->leave_start_date;
            $data['leave_end_date'] = $this->leave_end_date;
            
            if ($this->medical_certificate) {
                $data['medical_certificate'] = $this->medical_certificate->store('medical_certificates', 'public');
            }
        }

        // Handle proof document
        if ($this->proof_document) {
            $data['proof_document'] = $this->proof_document->store('proof_documents', 'public');
        }

        Permission::create($data);

        return redirect()->route('home.show', $this->attendanceId)->with('success', 'Permintaan izin berhasil diajukan. Silahkan tunggu persetujuan admin.');
    }

    public function render()
    {
        return view('livewire.permission-form');
    }
}
