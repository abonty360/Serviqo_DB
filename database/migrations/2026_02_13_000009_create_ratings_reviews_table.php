<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('ratings_reviews', function (Blueprint $table) {
            $table->id(); 

            $table->foreignId('customer_id') 
                ->constrained()
                ->noActionOnDelete();

            $table->foreignId('service_provider_id') 
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('service_order_id') 
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('rating'); 
            $table->date('review_date')->useCurrent();

            $table->text('review_notes')->nullable();

            $table->unique(['customer_id', 'service_order_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings_reviews');
    }
};