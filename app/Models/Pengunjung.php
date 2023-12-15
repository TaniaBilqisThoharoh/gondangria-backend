<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'nama', 'email', 'no_telepon', 'tanggal', 'subtotal', 'jumlah_tiket'];

    public function tiket() {
        return $this->hasMany(Tiket::class);
    }
}
