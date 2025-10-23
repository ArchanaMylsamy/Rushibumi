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
        Schema::table('video_files', function (Blueprint $table) {
            $table->integer('width')->nullable()->after('quality');
            $table->integer('height')->nullable()->after('width');
            $table->string('bitrate', 20)->nullable()->after('height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_files', function (Blueprint $table) {
            $table->dropColumn(['width', 'height', 'bitrate']);
        });
    }
};
