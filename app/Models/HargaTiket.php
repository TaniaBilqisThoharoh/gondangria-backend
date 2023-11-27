<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaTiket extends Model
{
    use HasFactory;
    protected $table = 'harga_tiket';
    protected $fillable = ['harga_tiket'];
}
