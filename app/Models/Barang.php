<?php

namespace App\Models;

use App\KondisiBarang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kondisi', 'jumlah'];

    protected $casts = [
        'kondisi' => KondisiBarang::class,
    ];

    public function mutasiBarang()
    {
        return $this->hasMany(MutasiBarang::class, 'id_barang');
    }
}
