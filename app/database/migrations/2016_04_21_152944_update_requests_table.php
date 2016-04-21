<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add column for free tests
		Schema::table('requests', function(Blueprint $table)
		{
			$table->string('quantity_remaining')->nullable()->after('item_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Reverse up
		Schema::table('requests', function(Blueprint $table){
			$table->dropColumn('quantity_remaining');
		});
	}
}