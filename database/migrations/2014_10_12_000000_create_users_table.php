<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('user_name')->unique();
            $table->boolean('gender')->comment('0 -> female, 1 -> male');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('age');
            $table->string('location');
            $table->string('password');
            $table->text('about');
            $table->text('hobbies');
            $table->integer('role_id');
            $table->string('avatar');
            // $table->string('cover_photo')->nullable();
            $table->string('price')->nullable();
            $table->string('status')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}