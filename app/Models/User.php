<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const OPERATOR_ROLE_ID = 1;
    const KARYAWAN_ROLE_ID = 2;
    const GURU_ROLE_ID = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'position_id',
        'division_id',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'teacher_id');
    }

    public function scopeOnlyEmployees($query)
    {
        return $query->whereIn('role_id', [self::KARYAWAN_ROLE_ID, self::GURU_ROLE_ID]);
    }

    public function isOperator()
    {
        return $this->role_id === self::OPERATOR_ROLE_ID;
    }

    public function isKaryawan()
    {
        return $this->role_id === self::KARYAWAN_ROLE_ID;
    }

    public function isGuru()
    {
        return $this->role_id === self::GURU_ROLE_ID;
    }

    // Untuk backward compatibility
    public function isAdmin()
    {
        return $this->isOperator();
    }

    public function isUser()
    {
        return $this->isKaryawan() || $this->isGuru();
    }
}
