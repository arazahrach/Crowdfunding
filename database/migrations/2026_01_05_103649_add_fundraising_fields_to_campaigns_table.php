<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // owner
            if (!Schema::hasColumn('campaigns', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }

            // category
            if (!Schema::hasColumn('campaigns', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('user_id')->constrained('categories')->nullOnDelete();
            }

            // fundraising fields
            if (!Schema::hasColumn('campaigns', 'short_title')) {
                $table->string('short_title', 255)->nullable()->after('title');
            }

            if (!Schema::hasColumn('campaigns', 'goal')) {
                $table->string('goal', 255)->nullable()->after('short_title');
            }

            if (!Schema::hasColumn('campaigns', 'village')) {
                $table->string('village', 120)->nullable()->after('goal');
            }
            if (!Schema::hasColumn('campaigns', 'district')) {
                $table->string('district', 120)->nullable()->after('village');
            }
            if (!Schema::hasColumn('campaigns', 'city')) {
                $table->string('city', 120)->nullable()->after('district');
            }
            if (!Schema::hasColumn('campaigns', 'province')) {
                $table->string('province', 120)->nullable()->after('city');
            }

            if (!Schema::hasColumn('campaigns', 'usage_details')) {
                $table->text('usage_details')->nullable()->after('description');
            }

            if (!Schema::hasColumn('campaigns', 'status')) {
                // pending | active | rejected | closed
                $table->string('status', 20)->default('pending')->after('is_active');
                $table->index('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // drop FK dulu
            if (Schema::hasColumn('campaigns', 'category_id')) $table->dropConstrainedForeignId('category_id');
            if (Schema::hasColumn('campaigns', 'user_id')) $table->dropConstrainedForeignId('user_id');

            if (Schema::hasColumn('campaigns', 'short_title')) $table->dropColumn('short_title');
            if (Schema::hasColumn('campaigns', 'goal')) $table->dropColumn('goal');
            if (Schema::hasColumn('campaigns', 'village')) $table->dropColumn('village');
            if (Schema::hasColumn('campaigns', 'district')) $table->dropColumn('district');
            if (Schema::hasColumn('campaigns', 'city')) $table->dropColumn('city');
            if (Schema::hasColumn('campaigns', 'province')) $table->dropColumn('province');
            if (Schema::hasColumn('campaigns', 'usage_details')) $table->dropColumn('usage_details');
            if (Schema::hasColumn('campaigns', 'status')) $table->dropColumn('status');
        });
    }
};
