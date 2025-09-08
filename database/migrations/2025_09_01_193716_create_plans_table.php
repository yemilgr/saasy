<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('stripe_product_id')->unique()->nullable();
            $table->foreignId('role_id')->constrained()->onDelete('restrict')->onUpdate('restrict');
            $table->boolean('active')->default(1);
            $table->boolean('default')->default(0);
            $table->boolean('popular')->default(0);
            $table->unsignedTinyInteger('trial_period_days')->nullable();
            $table->json('features');
            $table->timestamps();
        });

        Schema::create('plan_prices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('plan_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('stripe_price_id')->unique()->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->integer('amount'); // amount in cents
            $table->enum('interval', ['month', 'year'])->nullable(); // month, year
            $table->unsignedTinyInteger('interval_count')->default(1);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
        Schema::dropIfExists('plan_prices');
    }
};
