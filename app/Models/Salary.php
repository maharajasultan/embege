<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'bulan_tahun',
        'jumlah_hadir',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'total_bersih',
        'status_pembayaran',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
