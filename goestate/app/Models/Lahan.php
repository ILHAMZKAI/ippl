<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;
    protected $table = 'datalahan';
    protected $fillable = [
        'nama',
        'jumlah_baris',
        'jumlah_kolom',
        'user_id',
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($datalahan) {
            $datalahan->marks()->delete();
            $datalahan->times()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'idlahan');
    }

    public function times()
    {
        return $this->hasMany(Timer::class, 'lahan_id');
    }
}
