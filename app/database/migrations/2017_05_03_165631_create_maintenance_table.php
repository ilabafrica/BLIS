<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('maintenance', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('performed_by');
			$table->string('instrument', 25);
			$table->string('reason', 25);
			$table->date('start');
			$table->date('end');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
