<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resepsionis extends Model
{
    protected $fillable = [
        'kamar_id', 'nama', 'email', 'telepon',
        'jumlah_orang', 'jumlah_pesan',
        'checkin', 'checkout', 'status', 'bukti_pembayaran'
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
