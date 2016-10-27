<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugAbbreviationColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('drugs', function($table)
		{
		    $table->string('abbreviation', 10)->nullable()->after('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('drugs', function(Blueprint $table)
		{
			$table->dropColumn('abbreviation');
		});
	}
}
