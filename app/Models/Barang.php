<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'nama_barang', 'kategori_id', 'jenis_id', 'lokasi_id', 'kelengkapan', 'keterangan', 'status'];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'merek_id');
    }
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
    public function riwayats()
    {
        return $this->hasMany(Riwayat::class);
    }
}
