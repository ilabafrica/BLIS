<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCriticalValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('critical', function($table)
		{
		    $table->tinyInteger('age_unit')->nullable()->after('age_max');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('critical', function(Blueprint $table)
		{
			$table->dropColumn('age_unit');
		});
	}
}