<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('sub_services', function (Blueprint $table) {
            $table->id();

            $table->string('service_name');

            $table->text('description')->nullable();

            $table->foreignId('category_id') 
                ->constrained()
                ->cascadeOnDelete();
                
            $table->unique(['category_id', 'service_name']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_services');
    }
};