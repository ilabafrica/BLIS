<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSystemTasks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('command');
			$table->string('script_location');
			$table->string('intervals');
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
		Schema::table('system_tasks', function(Blueprint $table)
		{
			Schema::drop('system_tasks');
		});
	}

}
