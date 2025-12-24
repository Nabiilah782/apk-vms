<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_name',
        'address',
        'contact_person'
    ];

    public function documents()
    {
        return $this->hasMany(VendorDocument::class);
    }

    // Relasi many-to-many dengan list_service_catalog
    public function serviceLists()
    {
        return $this->belongsToMany(
            ListServiceCatalog::class,
            'vendor_service_lists', // nama tabel pivot
            'vendor_id',
            'list_service_catalog_id'
        )->withTimestamps();
    }
}