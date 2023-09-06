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
            $table->bigInteger('page_post_id')->nullable();
            $table->text('post_comment_caption')->nullable();
            $table->string('post_image_video')->nullable();
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
