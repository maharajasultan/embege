<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'nama_lengkap',
        'posisi',
        'foto_url',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function menusAsChef()
    {
        return $this->hasMany(Menu::class, 'chef_id');
    }

    public function menusAsSupir()
    {
        return $this->hasMany(Menu::class, 'supir_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function getFotoAttribute(): string
    {
        if ($this->foto_url) {
            return asset('storage/' . $this->foto_url);
        }
        return asset('images/default-avatar.png');
    }

    public function getPosisiLabelAttribute(): string
    {
        return match($this->posisi) {
            'chef'     => 'Chef / Koki',
            'supir'    => 'Driver Distribusi',
            'manajer'  => 'Manajer Dapur',
            'admin'    => 'Admin',
            default    => 'Staf Operasional',
        };
    }
}
