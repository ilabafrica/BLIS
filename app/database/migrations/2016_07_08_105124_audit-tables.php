<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AuditTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('audit_results', function (Blueprint $table){
			$table->increments('id')->unsigned();
			$table->string('previous_results');
			$table->bigInteger('test_result_id')->unsigned();
			$table->integer('user_id')->unsigned();

			$table->softDeletes();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('test_result_id')->references('id')->on('test_results');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('audit_results');
	}
}
