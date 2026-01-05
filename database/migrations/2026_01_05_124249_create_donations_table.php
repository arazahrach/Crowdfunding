<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();

            // kalau donor login (opsional)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // donor info (untuk guest)
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->unsignedBigInteger('amount');
            $table->text('message')->nullable();
            $table->boolean('is_anonymous')->default(false);

            // payment (untuk nanti Midtrans)
            $table->enum('status', ['pending', 'paid', 'failed'])->default('paid');
            $table->string('payment_ref')->nullable();

            $table->timestamps();

            $table->index(['campaign_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
