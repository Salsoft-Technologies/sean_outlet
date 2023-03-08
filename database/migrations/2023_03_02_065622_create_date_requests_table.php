<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('male_id')->constrained('users');
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
        Schema::dropIfExists('date_requests');
    }
}
