<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMeasuresChangeAgeColumnToFloat extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	
		 DB::statement('ALTER TABLE measure_ranges MODIFY age_min  FLOAT;');
		 DB::statement('ALTER TABLE measure_ranges MODIFY age_max  FLOAT;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		 DB::statement('ALTER TABLE measure_ranges MODIFY age_min  INTEGER;');
		 DB::statement('ALTER TABLE measure_ranges MODIFY age_max  INTEGER;');
	}

}
