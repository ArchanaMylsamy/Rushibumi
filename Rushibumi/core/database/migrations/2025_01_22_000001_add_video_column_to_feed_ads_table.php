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
        if (Schema::hasTable('feed_ads')) {
            Schema::table('feed_ads', function (Blueprint $table) {
                if (!Schema::hasColumn('feed_ads', 'video')) {
                    $table->string('video')->nullable()->after('image');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('feed_ads')) {
            Schema::table('feed_ads', function (Blueprint $table) {
                if (Schema::hasColumn('feed_ads', 'video')) {
                    $table->dropColumn('video');
                }
            });
        }
    }
};
