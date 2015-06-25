<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_types', function($table)
		{
		    $table->tinyInteger('accredited')->nullable()->after('prevalence_threshold');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('test_types', function(Blueprint $table)
		{
			$table->dropColumn('accredited');
		});
	}

}
