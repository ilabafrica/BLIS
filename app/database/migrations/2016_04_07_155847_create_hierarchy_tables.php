<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHierarchyTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->string('hq',100)->unique();
            $table->integer('user_id')->unsigned();


            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });

		//Counties tables
		Schema::create('counties', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->integer('country_id')->unsigned();
            $table->integer('user_id')->unsigned();


            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });

       

        Schema::table('facilities', function(Blueprint $table)
		{
			$table->integer('county_id')->unsigned()->after('name');

			$table->foreign('county_id')->references('id')->on('counties');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('facilities', function(Blueprint $table){
			$table->dropColumn('county_id');
		});
		Schema::dropIfExists('counties');
		Schema::dropIfExists('countries');
	}
}
