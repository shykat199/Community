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
        Schema::create('community_user_profile_education', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('degree_name',50)->nullable();
            $table->string('institute',50)->nullable();
            $table->text('description')->nullable();
            $table->string('designation',50)->nullable();
            $table->date('starting_date')->nullable();
            $table->date('ending_date')->nullable();
            $table->boolean('is_present')->nullable()->default(0);
            $table->string('type',10)->nullable()->default('e');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_user_profile_education');
    }
};
