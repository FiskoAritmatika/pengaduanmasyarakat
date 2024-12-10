<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pengaduan;

class Tanggapan extends Model
{
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    protected $fillable = [
        'pengaduan_id',
        'tgl_tanggapan',
        'tanggapan',
        'user_id',
    ];
}
