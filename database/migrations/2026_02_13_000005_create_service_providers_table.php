<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');

            $table->string('email')->unique();
            $table->string('phone');

            $table->string('address')->nullable();
            $table->string('city');

            $table->decimal('rating', 3, 2)->default(0.00);

            $table->string('nid')->unique();
            $table->foreignId('service_area_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('service_providers');
    }
};