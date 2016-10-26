<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloodBankTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blood_bank', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('bag_number', 25);
			$table->tinyInteger('blood_group');
			$table->string('volume', 25);
			$table->date('date_collected');
			$table->date('expiry_date');

			$table->timestamps();
			$table->softDeletes();
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
