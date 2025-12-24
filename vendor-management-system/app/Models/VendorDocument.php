<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VendorDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'file_path',
    ];

    // Relasi ke vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Get file name from path
    public function getFileNameAttribute()
    {
        return basename($this->file_path);
    }

    // Get file size
    public function getFileSizeAttribute()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            return Storage::disk('public')->size($this->file_path);
        }
        return 0;
    }

    // Format file size
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes === 0) return '0 Bytes';
        
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    // Get file extension
    public function getFileExtensionAttribute()
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    // Get download URL
    public function getDownloadUrlAttribute()
    {
        return route('vendor.documents.download', $this->id);
    }

    // Get view URL
    public function getViewUrlAttribute()
    {
        return route('vendor.documents.view', $this->id);
    }
}