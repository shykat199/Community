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
        Schema::create('ticket_reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('train_id');
            $table->bigInteger('coach_id');
            $table->bigInteger('user_id');
            $table->integer('train_seat');
            $table->integer('adult_passenger');
            $table->integer('child_passenger');
            $table->time('date_of_journey');
            $table->string('from_station',25);
            $table->string('to_station',25);
            $table->integer('child_price');
            $table->integer('adult_price');
            $table->integer('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket__reservations');
    }
};
