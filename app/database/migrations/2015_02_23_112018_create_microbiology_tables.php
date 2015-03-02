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
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('organism_id')->references('id')->on('organisms');
            $table->foreign('drug_id')->references('id')->on('drugs');
            $table->unique(array('organism_id','drug_id'));
        });
        /* testType_organisms table */
        Schema::create('testtype_organisms', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('test_type_id')->unsigned();
            $table->integer('organism_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('organism_id')->references('id')->on('organisms');
            $table->unique(array('test_type_id','organism_id'));
        });
        /* culture worksheet table */
        Schema::create('culture_worksheet', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('test_id')->unsigned();
            $table->string('observation',300);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('test_id')->references('id')->on('tests');
        });
        /* drug susceptibility table */
        Schema::create('drug_susceptibility', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('test_id')->unsigned();
            $table->integer('organism_id')->unsigned();
            $table->integer('drug_id')->unsigned();
            $table->string('zone',5);
            $table->string('interpretation',2);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('organism_id')->references('id')->on('organisms');
            $table->foreign('drug_id')->references('id')->on('drugs');
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
		/* testType_organisms table */
		Schema::dropIfExists('testtype_organisms');
		/* culture worksheet table */
		Schema::dropIfExists('culture_worksheet');
		/* drug susceptibility table */
		Schema::dropIfExists('drug_susceptibility');
	}

}
