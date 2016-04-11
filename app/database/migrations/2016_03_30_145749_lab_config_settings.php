<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LabConfigSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* quick codes */
		Schema::create('ii_quickcodes', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->tinyInteger('feed_source');
            $table->string('config_prop', 50);

            $table->softDeletes();
            $table->timestamps();
        });
		/* interfaced equipment */
		Schema::create('interfaced_equipment', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('equipment_name', 50);
            $table->tinyInteger('comm_type');
            $table->string('equipment_version', 50);
            $table->integer('lab_section')->unsigned();
            $table->tinyInteger('feed_source');
            $table->string('config_file', 2000);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('lab_section')->references('id')->on('test_categories');
        });
        /* equip config */
        Schema::create('equip_config', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('equip_id')->unsigned();
            $table->integer('prop_id')->unsigned();
            $table->string('prop_value', 50);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('equip_id')->references('id')->on('interfaced_equipment');
            $table->foreign('prop_id')->references('id')->on('ii_quickcodes');
        });
		/* barcode settings */
		Schema::create('barcode_settings', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('encoding_format', 100);
            $table->string('barcode_width', 100);
            $table->string('barcode_height', 100);
            $table->string('text_size', 100);

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
		Schema::drop('barcode_settings');
		Schema::drop('equip_config');
		Schema::drop('interfaced_equipment');
		Schema::drop('ii_quickcodes');
	}
}
