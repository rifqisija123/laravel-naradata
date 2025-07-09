<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'jenis_id', 'barang_id', 'nama_barang', 'karyawan_id', 'keterangan', 'tanggal'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $lastId = self::withTrashed()->latest('id')->first();
            $number = $lastId ? (int) substr($lastId->id, 2) + 1 : 1;
            $model->id = 'RY' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }
    public function jenis() { return $this->belongsTo(Jenis::class, 'jenis_id', 'merek_id'); }
    public function barang() { return $this->belongsTo(Barang::class); }
    public function karyawan() { return $this->belongsTo(Karyawan::class); }
}
