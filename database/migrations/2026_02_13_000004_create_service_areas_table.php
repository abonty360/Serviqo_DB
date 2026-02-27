<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('service_areas', function (Blueprint $table) {
            $table->id(); 

            $table->string('city_name');
            $table->string('area_name');

            $table->string('postal_code')->nullable();

            $table->unique(['city_name', 'area_name']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_areas');
    }
};