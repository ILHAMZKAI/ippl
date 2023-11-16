<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;
    protected $table = 'marks';
    protected $fillable = [
        'idlahan',
        'id_user',
        'data_col',
        'data_row',
        'warna',
        'berat',
    ];
}

