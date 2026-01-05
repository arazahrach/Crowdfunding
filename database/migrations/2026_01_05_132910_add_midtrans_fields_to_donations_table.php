<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // order_id Midtrans (unik)
            $table->string('order_id')->nullable()->unique()->after('payment_ref');

            // snap token untuk tampilkan popup
            $table->string('snap_token')->nullable()->after('order_id');

            // metadata pembayaran (opsional tapi berguna)
            $table->string('payment_type')->nullable()->after('snap_token');
            $table->string('transaction_status')->nullable()->after('payment_type');
            $table->string('fraud_status')->nullable()->after('transaction_status');

            // simpan response json untuk debug
            $table->json('raw_response')->nullable()->after('fraud_status');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropUnique(['order_id']);
            $table->dropColumn([
                'order_id',
                'snap_token',
                'payment_type',
                'transaction_status',
                'fraud_status',
                'raw_response',
            ]);
        });
    }
};
