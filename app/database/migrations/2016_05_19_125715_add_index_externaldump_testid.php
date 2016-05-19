<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexExternaldumpTestid extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('external_dump', function(Blueprint $table)
		{
			$table->dropIndex('test_id');
			$table->unique('test_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('external_dump', function(Blueprint $table)
		{
			$table->dropUnique('test_id');
		});
	}

}
