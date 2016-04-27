<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvRequestUsage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('requests', function(Blueprint $table)
		{
			$table->integer('tests_done')->default(0);
		});
		Schema::table('inv_usage', function(Blueprint $table)
		{
			$table->string('issued_by')->nullable();
			$table->string('received_by')->nullable();
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
			$table->dropColumn('tests_done');
		});
		Schema::table('inv_usage', function(Blueprint $table){
			$table->dropColumn('issued_by');
			$table->dropColumn('received_by');
		});
	}
}
