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
        Schema::create('ticket_fears', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('train_id');
            $table->bigInteger('coach_id');
            $table->bigInteger('seat_id');
            $table->string('from_station',25);
            $table->string('to_station',25);
            $table->integer('price_of_adult');
            $table->integer('price_of_child');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket__fears');
    }
};
