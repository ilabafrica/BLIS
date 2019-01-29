<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmrTestTypeAliasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emr_test_type_aliases', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('client_id')->unsigned();
           $table->integer('test_type_id')->unsigned();
           $table->string('emr_alias');
       });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('emr_test_type_aliases');
	}

}
