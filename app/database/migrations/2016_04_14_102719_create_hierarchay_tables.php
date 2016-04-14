<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHierarchayTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('region_types', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->integer('user_id')->unsigned();


            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });

		//Counties tables
		Schema::create('regions', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->integer('region_type_id')->unsigned();
            $table->integer('user_id')->unsigned();


            $table->foreign('region_type_id')->references('id')->on('region_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('region_tiers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->integer('tier_id')->unsigned();
            $table->integer('user_id')->unsigned();


            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('tier_id')->references('id')->on('regions');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
		Schema::create('region_type_tiers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('region_type_id')->unsigned();
            $table->integer('tier_id')->unsigned();
            $table->integer('user_id')->unsigned();


            $table->foreign('region_type_id')->references('id')->on('region_types');
            $table->foreign('tier_id')->references('id')->on('region_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('facilities', function(Blueprint $table)
		{
			$table->integer('region_id')->unsigned()->after('name');

			$table->foreign('region_id')->references('id')->on('regions');
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
			$table->dropForeign('facilities_region_id_foreign');
			$table->dropColumn('region_id');
		});
		Schema::dropIfExists('region_type_tiers');
		Schema::dropIfExists('region-tiers');
		Schema::dropIfExists('regions');
		Schema::dropIfExists('region_types');
	}

}

