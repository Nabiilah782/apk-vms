<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('list_service_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('list_name');
            $table->timestamps();
        });

        // Tabel pivot untuk menghubungkan vendor dengan list_service_catalog
        Schema::create('vendor_service_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->foreignId('list_service_catalog_id')->constrained('list_service_catalog')->onDelete('cascade');
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi
            $table->unique(['vendor_id', 'list_service_catalog_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_service_lists');
        Schema::dropIfExists('list_service_catalog');
    }
};  