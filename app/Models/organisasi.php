<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organisasi extends Model
{
    protected $table = 'organisasi';

    protected $fillable = [
        'nama',
    ];

}
