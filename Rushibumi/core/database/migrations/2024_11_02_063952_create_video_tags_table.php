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
        if (!Schema::hasTable('video_tags')) {
            Schema::create('video_tags', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('video_id');
                $table->string('tag');
                $table->timestamps();
                
                $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
                $table->index('tag');
                $table->index('video_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_tags');
    }
};
