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
        Schema::create('community_page_post_file_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('page_id');
            $table->text('post_comment_caption');
            $table->string('post_image_video');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_page_post_file_types');
    }
};
