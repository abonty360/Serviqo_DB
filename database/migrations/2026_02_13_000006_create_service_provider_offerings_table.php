<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('service_provider_offerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id') 
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('sub_service_id') 
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('price_charged', 10, 2);

            $table->decimal('rating', 3, 2)->default(0.00);

            $table->unique(
                ['service_provider_id', 'sub_service_id'],
                'spo_provider_service_unique'
            );

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_provider_offerings');
    }
};