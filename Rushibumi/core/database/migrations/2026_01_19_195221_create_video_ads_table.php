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
        Schema::create('video_ads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('video')->nullable(); // Video file
            $table->string('thumbnail')->nullable(); // Video thumbnail/poster
            $table->string('url')->nullable(); // Click URL
            $table->tinyInteger('ad_type')->default(1)->comment('1=pre-roll (before video), 2=mid-roll (during video), 3=post-roll (after video)');
            $table->integer('skip_after')->default(5)->comment('Seconds before skip button appears (0 = no skip)');
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=inactive');
            $table->integer('clicks')->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('plays')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_ads');
    }
};
