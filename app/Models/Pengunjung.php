<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'email', 'no_telepon'];

    public function tiket() {
        return $this->hasMany(Tiket::class);
    }
}
