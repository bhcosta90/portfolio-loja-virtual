<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('brand_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_visible')->default(false);
            $table->boolean('backorder')->default(false);
            $table->boolean('requires_shipping')->default(false);
            $table->date('published_at');
            $table->unsignedInteger('price_actual');
            $table->unsignedInteger('price_old')->nullable();
            $table->unsignedInteger('price_cost')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
