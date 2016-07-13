<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustRegFieldsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  Create table for modules
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->timestamps();
        });
        //  Custom field types
        Schema::create('custom_field_types', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        //  Custom fields
        Schema::create('custom_fields', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->integer('custom_field_type_id')->unsigned();
            $table->string('options', 250)->nullable();
            $table->tinyInteger('required')->default(0);

            $table->foreign('custom_field_type_id')->references('id')->on('custom_field_types');

            $table->softDeletes();
            $table->timestamps();
        });
        //  Custom field types
        Schema::create('module_custom_fields', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('custom_field_id')->unsigned();
            $table->integer('module_id')->unsigned();

            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('custom_field_id')->references('id')->on('custom_fields');
            
            $table->softDeletes();
            $table->timestamps();
        });
        //  Custom field values
        Schema::create('custom_field_values', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('module_custom_field_id')->unsigned();
            $table->integer('data_key');
            $table->string('data_value')->nullable();

            $table->foreign('module_custom_field_id')->references('id')->on('module_custom_fields');

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
        //
    }
}