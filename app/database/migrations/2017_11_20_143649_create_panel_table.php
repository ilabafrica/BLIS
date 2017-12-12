<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('panel', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->string('description',100)->nullable();
            $table->integer('active')->default(1);
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
		Schema::dropIfExists('panel');
	}

}
