<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments("id")->unsigned();
            $table->string("username", 50)->unique();
            $table->string("password", 100);
            $table->string("email", 100);
            $table->string("name", 100)->nullable();
            $table->tinyInteger("gender")->default(0);
            $table->string("designation", 100)->nullable();
            $table->string("image", 100)->nullable();
            $table->string("remember_token", 100)->nullable();

            $table->softDeletes();
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