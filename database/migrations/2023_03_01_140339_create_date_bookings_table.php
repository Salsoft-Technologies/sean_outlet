<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('male_id')->constrained('users');
            $table->string('card_holder_name');
            $table->bigInteger('card_number');
            $table->integer('cvv');
            $table->string('expiry_date');
            $table->integer('price');
            $table->foreignId('female_id')->constrained('users');
            $table->foreignId('slot_id')->constrained('time_slots');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_bookings');
    }
}