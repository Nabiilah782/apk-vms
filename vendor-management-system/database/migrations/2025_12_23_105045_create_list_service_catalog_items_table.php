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
        Schema::create('list_service_catalog_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')
                  ->constrained('list_service_catalog')
                  ->onDelete('cascade');
            $table->foreignId('service_id')
                  ->constrained('service_catalog')
                  ->onDelete('cascade');
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi
            $table->unique(['list_id', 'service_id']);
            
            // Index untuk performa query
            $table->index(['list_id']);
            $table->index(['service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_service_catalog_items');
    }
};