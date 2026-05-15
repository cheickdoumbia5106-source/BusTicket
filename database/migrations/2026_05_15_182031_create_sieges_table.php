<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sieges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->integer('numero_siege');
            $table->integer('rang'); // 1 à 10
            $table->integer('colonne'); // 1 à 5
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sieges');
    }
};