<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FreeTestsColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add column for free tests
		Schema::table('test_types', function(Blueprint $table)
		{
			$table->integer('orderable_test')->nullable()->after('targetTAT');
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
		Schema::table('test_types', function(Blueprint $table){
			$table->dropColumn('orderable_test');
		});
	}

}
