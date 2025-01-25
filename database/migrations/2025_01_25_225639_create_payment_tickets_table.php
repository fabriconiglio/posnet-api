<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payment_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_card_id')->constrained();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('installment_amount', 10, 2);
            $table->integer('installments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_tickets');
    }
};
