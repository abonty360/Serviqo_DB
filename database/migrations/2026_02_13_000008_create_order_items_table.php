<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_order_id') 
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('service_provider_offering_id') 
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('quantity')->default(1);

            $table->decimal('item_price', 10, 2);

            $table->string('item_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};