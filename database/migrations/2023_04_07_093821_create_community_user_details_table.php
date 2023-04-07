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
        Schema::create('community_user_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('dob')->nullable();
            $table->string('birthplace',50)->nullable();
            $table->string('phone',30)->nullable();
            $table->string('gender',10)->nullable();
            $table->string('relationship',50)->nullable();
            $table->string('blood',10)->nullable();
            $table->string('website',10)->nullable();
            $table->text('about_me')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_user_details');
    }
};
