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
        if (!Schema::hasTable('feed_ads')) {
            Schema::create('feed_ads', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('image')->nullable(); // Static image, GIF, or video thumbnail
                $table->string('video')->nullable(); // Video file (optional, for video ads)
                $table->string('url')->nullable(); // Click URL
                $table->tinyInteger('ad_type')->default(1)->comment('1=image, 2=gif, 3=video');
                $table->tinyInteger('position')->default(1)->comment('1=feed, 2=top');
                $table->tinyInteger('status')->default(1)->comment('1=active, 0=inactive');
                $table->integer('priority')->default(0)->comment('Higher priority ads shown more often');
                $table->integer('clicks')->default(0);
                $table->integer('impressions')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_ads');
    }
};
