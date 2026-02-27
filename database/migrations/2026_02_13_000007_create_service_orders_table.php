<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id') 
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status')->default('pending');

            $table->decimal('total_amount', 10, 2)->default(0.00);

            $table->string('payment_status')->default('unpaid');

            $table->timestamp('order_datetime')->useCurrent();

            $table->timestamp('scheduled_datetime')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};