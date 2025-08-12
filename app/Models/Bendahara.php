<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bendahara extends Model
{
    use HasFactory;

    protected $table = 'bendahara';

    protected $fillable = [
        'judul',
        'dokumen',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Accessor for file extension
    public function getFileExtensionAttribute()
    {
        if ($this->dokumen) {
            return strtoupper(pathinfo($this->dokumen, PATHINFO_EXTENSION));
        }
        return null;
    }

    // Accessor for file size (if you want to store and display file size)
    public function getFileSizeAttribute()
    {
        if ($this->dokumen) {
            $filePath = storage_path('app/public/' . $this->dokumen);
            if (file_exists($filePath)) {
                $bytes = filesize($filePath);
                $units = ['B', 'KB', 'MB', 'GB'];
                $factor = floor((strlen($bytes) - 1) / 3);
                return sprintf("%.2f", $bytes / pow(1024, $factor)) . ' ' . $units[$factor];
            }
        }
        return null;
    }

    // Accessor for formatted created date
    public function getFormattedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M Y') : null;
    }

    // Check if document exists
    public function hasDocument()
    {
        return !empty($this->dokumen) && file_exists(storage_path('app/public/' . $this->dokumen));
    }

    // Get document URL
    public function getDocumentUrlAttribute()
    {
        return $this->dokumen ? asset('storage/' . $this->dokumen) : null;
    }
}
