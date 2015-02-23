<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrobiologyTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* Drugs table */
		Schema::create('drugs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->string('description',100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        /* Organisms table */
		Schema::create('organisms', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->string('description',100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        /* Organism_Drugs table */
        Schema::create('organism_drugs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('organism_id')->unsigned();
            $table->integer('drug_id')->unsigned();

            $table->foreign('organism_id')->references('id')->on('organisms');
            $table->foreign('drug_id')->references('id')->on('drugs');
            $table->unique(array('organism_id','drug_id'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/* Drugs table */
		Schema::dropIfExists('drugs');
		/* Organisms table */
		Schema::dropIfExists('organisms');
		/* Organism_Drugs table */
		Schema::dropIfExists('organism_drugs');
	}

}
