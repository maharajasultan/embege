<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'nama_menu',
        'daftar_lauk',
        'kalori',
        'karbohidrat',
        'protein',
        'chef_id',
        'supir_id',
        'status',
        'foto_url',
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'daftar_lauk' => 'array',
    ];

    public function getFotoAttribute(): string
    {
        if ($this->foto_url) {
            return asset('storage/' . $this->foto_url);
        }
        return asset('images/default-menu.png');
    }

    public function chef()
    {
        return $this->belongsTo(Staff::class, 'chef_id');
    }

    public function supir()
    {
        return $this->belongsTo(Staff::class, 'supir_id');
    }

    public function getHariAttribute(): string
    {
        $hari = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        return $hari[$this->tanggal->format('l')] ?? $this->tanggal->format('l');
    }

    public function getTanggalFormatAttribute(): string
    {
        return $this->tanggal->format('d M Y');
    }
}
