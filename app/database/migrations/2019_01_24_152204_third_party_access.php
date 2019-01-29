<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThirdPartyAccess extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
 public function up()
    {
        Schema::create('third_party_access', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable();
            $table->integer('third_party_app_id')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('access_token',500)->nullable();
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
        Schema::dropIfExists('third_party_access');
    }

}
