<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();

            // owner campaign
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // category
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // core fields
            $table->string('title');
            $table->string('slug')->unique();

            $table->string('short_title')->nullable();
            $table->text('purpose')->nullable();       // tujuan penggalangan
            $table->longText('description')->nullable(); // rincian penggunaan dana

            // image path (storage)
            $table->string('image')->nullable();

            // location (sesuaikan kebutuhanmu)
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();

            // fundraising numbers
            $table->unsignedBigInteger('target_amount')->default(0);
            $table->unsignedBigInteger('collected_amount')->default(0);

            // campaign period
            $table->date('end_date')->nullable();

            // status
            $table->enum('status', ['draft', 'active', 'closed'])->default('active');

            $table->timestamps();

            // indexes (buat search/filter cepat)
            $table->index(['status', 'created_at']);
            $table->index(['category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
