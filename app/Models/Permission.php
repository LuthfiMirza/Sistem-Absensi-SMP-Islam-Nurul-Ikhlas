<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'attendance_id',
        'title',
        'description',
        'type',
        'late_arrival_time',
        'early_departure_time',
        'leave_start_date',
        'leave_end_date',
        'medical_certificate',
        'proof_document',
        'permission_date',
        'status',
        'rejection_reason'
    ];

    protected $casts = [
        'permission_date' => 'date',
        'leave_start_date' => 'date',
        'leave_end_date' => 'date',
        'late_arrival_time' => 'datetime:H:i',
        'early_departure_time' => 'datetime:H:i'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function isSameDay()
    {
        return $this->type === 'same_day';
    }

    public function isLeave()
    {
        return $this->type === 'leave';
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('permission_date', $date);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Status helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return '<span class="badge bg-warning">Menunggu</span>';
            case 'accepted':
                return '<span class="badge bg-success">Diterima</span>';
            case 'rejected':
                return '<span class="badge bg-danger">Ditolak</span>';
            default:
                return '<span class="badge bg-secondary">Unknown</span>';
        }
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'Menunggu';
            case 'accepted':
                return 'Diterima';
            case 'rejected':
                return 'Ditolak';
            default:
                return 'Unknown';
        }
    }
}
