<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'jenis', 'merek_id', 'merek', 'keterangan'];
    protected $primaryKey = 'merek_id';
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $lastMerekId = self::withTrashed()->latest('merek_id')->first();
            $number = $lastMerekId ? (int) substr($lastMerekId->merek_id, 2) + 1 : 1;
            $model->merek_id = 'JM' . str_pad($number, 3, '0', STR_PAD_LEFT);

            $existingJenis = self::whereRaw('LOWER(jenis) = ?', [strtolower($model->jenis)])->first();
            if ($existingJenis) {
                $model->id = $existingJenis->id;
            } else {
                $lastJenisId = self::withTrashed()->latest('id')->first();
                $jenisNumber = $lastJenisId ? (int) substr($lastJenisId->id, 2) + 1 : 1;
                $model->id = 'JN' . str_pad($jenisNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'merek_id');
    }
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'jenis_id');
    }
}
