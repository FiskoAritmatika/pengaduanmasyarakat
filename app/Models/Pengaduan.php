<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tanggapan;

class Pengaduan extends Model
{
    protected $fillable = ['tgl_pengaduan', 'isi_laporan', 'foto', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class);
    }
}
