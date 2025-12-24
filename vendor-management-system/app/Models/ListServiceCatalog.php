<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListServiceCatalog extends Model
{
    use HasFactory;

    protected $table = 'list_service_catalog';
    
    protected $fillable = ['list_name'];

    // Relasi many-to-many dengan vendors
    public function vendors()
    {
        return $this->belongsToMany(
            Vendor::class,
            'vendor_service_lists',
            'list_service_catalog_id',
            'vendor_id'
        )->withTimestamps();
    }
     public function services()
    {
        return $this->belongsToMany(
            ServiceCatalog::class,
            'list_service_catalog_items',
            'list_id',
            'service_id'
        )->withTimestamps();
    }
}
