<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_order_id') // OrderID (FK)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('payment_method');

            $table->decimal('paid_amount', 10, 2);

            $table->timestamp('payment_datetime')->useCurrent();

            $table->string('transaction_reference')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};