<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    // Menentukan kolom yang diizinkan untuk diisi
    protected $fillable = ['judul', 'icon', 'deskripsi', 'status', 'tanggal'];
}
