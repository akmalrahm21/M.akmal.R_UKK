<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto', 'tipe_kamar', 'jumlah_kamar', 'fasilitas', 'harga_kamar'
    ];

    public function getAvailableRoomsAttribute()
    {
        $booked = $this->bookings()
            ->where('status', 'confirmed')
            ->where(function($query) {
                $query->where('check_out', '>=', now()->toDateString())
                      ->orWhereNull('check_out');
            })
            ->count();

        return max(0, $this->jumlah_kamar - $booked);
    }
}
