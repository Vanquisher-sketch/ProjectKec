<?php

// app/Models/Inventaris.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris'; // Nama tabel di database

    protected $guard = [];

    protected $fillable = [
        'nama_barang',
        'merk_model',
        'bahan',
        'tahun_pembelian',
        'kode_barang',
        'jumlah',
        'harga_perolehan',
        'kondisi',
        'keterangan',
    ];
}