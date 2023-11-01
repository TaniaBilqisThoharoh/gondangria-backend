<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;
    protected $table = 'fasilitas';
    protected $fillable = ['nama', 'gambar', 'deskripsi'];

    public function beranda() {
        return $this->belongsToMany(Beranda::class);
    }
}
