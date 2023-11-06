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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
