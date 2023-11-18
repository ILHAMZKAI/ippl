<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    use HasFactory;
    protected $table = 'times';

    protected $fillable = ['action', 'timer', 'lahan_id', 'iduser'];
}
