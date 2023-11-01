<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wahana;
use App\Models\Fasilitas;

class Beranda extends Model
{
    use HasFactory;
    protected $fillable = ['hero, wahana_id, fasilitas_id'];

    public function wahana() {
        return $this->belongsToMany(Wahana::class);
    }

    public function fasilitas() {
        return $this->belongsToMany(Fasilitas::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
