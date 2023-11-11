<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'idlahan',
        'id_user',
        'data_col',
        'data_row',
        'warna'
    ];
}

