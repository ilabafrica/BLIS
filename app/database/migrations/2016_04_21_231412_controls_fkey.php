<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ControlsFkey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lots', function(Blueprint $table)
		{
			$table->date('expiry')->after('instrument_id');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/*Schema::table('controls', function(Blueprint $table)
		{
			$table->dropForeign('controls_instrument_id_foreign');
			$table->dropColumn('instrument_id');
		});*/
	}
}
