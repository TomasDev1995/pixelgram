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
            $table->string('role', 20)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('surname', 200)->nullable();
            $table->string('nick', 100)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); //si o si verificar con mailtrap.io
            $table->string('password', 255);
            $table->string('image')->nullable();
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
