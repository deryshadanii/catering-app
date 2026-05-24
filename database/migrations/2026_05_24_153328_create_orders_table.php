<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_code')->unique();
            $table->text('delivery_address');
            $table->date('delivery_date')->nullable();
            $table->text('note')->nullable();
            $table->enum('payment_method', ['transfer_bank', 'e_wallet', 'cod'])->default('cod');
            $table->integer('subtotal')->default(0);
            $table->integer('delivery_fee')->default(0);
            $table->integer('total')->default(0);
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'delivering',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
