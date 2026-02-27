<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_confirmations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('confirmation_status', [
                'pending',
                'confirmed',
                'cancelled'
            ])->default('pending');
            $table->decimal('final_amount', 10, 2);
            $table->timestamp('confirmed_at')->useCurrent();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_confirmations');
    }
};
