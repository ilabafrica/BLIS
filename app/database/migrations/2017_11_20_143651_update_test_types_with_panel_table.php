<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestTypesWithPanelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_types', function($table)
		{
            $table->integer('panel_id')->unsigned()->nullable('false')->after('description');	
            $table->foreign('panel_id')->references('id')->on('panel');		
		});
       


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('test_types',function(Blueprint $table)
			{
				$table->dropColumn('panel_id');
			});
	}

}
