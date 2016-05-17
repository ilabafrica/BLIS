<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* create billing-settings table */
		Schema::create('billing', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('default_currency', 50);
            $table->string('currency_delimiter', 50);
            $table->string('image', 50)->nullable();
            $table->tinyInteger('enabled')->default(0);
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
        /* add cost column to test-types */
        Schema::create('test_type_costs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('test_type_id')->unsigned();
            $table->decimal('amount', 5, 2)->nullable();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('user_id')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/* reverse migration */
		Schema::dropIfExists('bliing');
		Schema::dropIfExists('test_type_costs');
	}
}
