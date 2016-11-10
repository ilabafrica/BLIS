<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToParentlabno extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('external_dump', function(Blueprint $table)
		{
			$table->index('parent_lab_no');
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
			$table->dropIndex('external_dump_parent_lab_no_index');
		});
	}

}
