<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'kuota_porsi',
        'foto_url',
    ];

    public function getFotoAttribute(): string
    {
        if ($this->foto_url) {
            return asset('storage/' . $this->foto_url);
        }
        return asset('images/default-school.png');
    }
}
