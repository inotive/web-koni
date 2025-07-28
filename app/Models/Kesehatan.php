<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kesehatan extends Model
{
    protected $table = 'kesehatan';

    protected $fillable = [
        'nama',
    ];

}
