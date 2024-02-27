<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('order_id')->constrained();
            $table->string('type');
            $table->unsignedBigInteger('value');
            $table->string('credit_card_name')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('credit_card_month')->nullable();
            $table->string('credit_card_year')->nullable();
            $table->string('credit_card_cvc')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
