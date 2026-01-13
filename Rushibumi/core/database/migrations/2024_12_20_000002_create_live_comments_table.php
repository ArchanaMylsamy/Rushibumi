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
        if (!Schema::hasTable('live_comments')) {
            Schema::create('live_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('live_stream_id');
                $table->unsignedBigInteger('user_id');
                $table->text('comment');
                $table->timestamps();
                
                $table->foreign('live_stream_id')->references('id')->on('live_streams')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index('live_stream_id');
                $table->index('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_comments');
    }
};

