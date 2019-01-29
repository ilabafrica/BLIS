<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosticOrderStatuses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		   Schema::create('diagnostic_order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('display');
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('diagnostic_order_statuses');
	}
	
	
}
