<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;
    protected $fillable = ['pengunjung_id'];

    public function pengunjung() {
        return $this->belongsTo(Pengunjung::class);
    }

    public function wahana() {
        return $this->belongsTo(Wahana::class);
    }
}
