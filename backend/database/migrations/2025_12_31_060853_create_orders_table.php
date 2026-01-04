<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();

            $table->string('order_code')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('visit_date');

            $table->integer('total_price')->default(0);

            $table->string('payment_gateway')->default('midtrans');
            $table->enum('payment_status', ['pending','paid','failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
