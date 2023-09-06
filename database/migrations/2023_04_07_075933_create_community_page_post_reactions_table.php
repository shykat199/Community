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
        Schema::create('community_page_post_reactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('page_post_id');
            $table->bigInteger('user_id');
            $table->enum('reaction_type',['haha','love','care','like','sad','wow','angry']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_page_post_reactions');
    }
};
