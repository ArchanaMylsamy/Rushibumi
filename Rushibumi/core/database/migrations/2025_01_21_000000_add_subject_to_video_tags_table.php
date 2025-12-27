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
        // Check if table exists, if not create it with all columns
        if (!Schema::hasTable('video_tags')) {
            Schema::create('video_tags', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('video_id');
                $table->string('tag');
                $table->string('subject')->nullable()->comment('Subject/category of the tag for sequential tagging');
                $table->timestamps();
                
                $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
                $table->index('tag');
                $table->index('subject');
                $table->index('video_id');
            });
        } else {
            // Table exists, just add subject column if it doesn't exist
            Schema::table('video_tags', function (Blueprint $table) {
                if (!Schema::hasColumn('video_tags', 'subject')) {
                    $table->string('subject')->nullable()->after('tag')->comment('Subject/category of the tag for sequential tagging');
                }
            });
            
            // Add index for subject if column was added
            if (Schema::hasColumn('video_tags', 'subject')) {
                Schema::table('video_tags', function (Blueprint $table) {
                    try {
                        $table->index('subject', 'idx_video_tags_subject');
                    } catch (\Exception $e) {
                        // Index might already exist
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_tags', function (Blueprint $table) {
            if (Schema::hasColumn('video_tags', 'subject')) {
                $table->dropColumn('subject');
            }
        });
    }
};

