<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiosafetyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing sops
        Schema::create('sops', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->string('file')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        // Create table for victim types
        Schema::create('victim_types', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        // Create table for incident types
        Schema::create('incident_types', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        // Create table for storing victims
        Schema::create('victims', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('victim_type_id')->unsigned();
            $table->string('fname', 100);
            $table->string('name', 100);
            $table->date('dob');
            $table->tinyInteger('gender')->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();

            $table->foreign('victim_type_id')->references('id')->on('victim_types');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
        // Create table for storing incidents
        Schema::create('incidents', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->date('incident_date');
            $table->string('scene', 100);
            $table->integer('victim_id')->unsigned();
            $table->integer('incident_type_id')->unsigned();
            $table->string('equipment_code', 100);
            $table->integer('sop_id')->unsigned();
            $table->string('description');
            $table->string('first_aid')->nullable();
            $table->string('corrective_action')->nullable();
            $table->string('reporting_officer');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();

            $table->foreign('victim_id')->references('id')->on('victims');
            $table->foreign('incident_type_id')->references('id')->on('incident_types');
            $table->foreign('sop_id')->references('id')->on('sops');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
        // Create table for incident follow-ups
        Schema::create('follow_ups', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('incident_id')->unsigned();
            $table->date('date_from');
            $table->date('date_to');
            $table->string('actions');
            $table->string('follow_up_officer');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();

            $table->foreign('incident_id')->references('id')->on('incidents');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_ups');
        Schema::dropIfExists('incidents');
        Schema::dropIfExists('victims');
        Schema::dropIfExists('incident_types');
        Schema::dropIfExists('victim_types');
        Schema::dropIfExists('sops');
    }
}