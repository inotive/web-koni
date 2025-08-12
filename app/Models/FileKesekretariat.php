<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileKesekretariat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dokumen',
        'dokumen_file',
    ];
}