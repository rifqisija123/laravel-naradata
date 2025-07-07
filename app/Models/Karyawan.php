<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'nama', 'jabatan', 'keterangan'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $lastId = self::withTrashed()->latest('id')->first();
            $number = $lastId ? (int) substr($lastId->id, 2) + 1 : 1;
            $model->id = 'KY' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }
}
