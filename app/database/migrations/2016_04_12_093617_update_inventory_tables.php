<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoryTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//	Drop existing tables
		Schema::dropIfExists('issues');
        Schema::dropIfExists('topup_requests');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('commodities');
        Schema::dropIfExists('metrics');
        /* inventory table */
        Schema::create('inv_items', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100)->unique();
            $table->string('unit', 100)->nullable();
            $table->decimal('min_level', 8, 2);
            $table->decimal('max_level', 8, 2)->nullable();
            $table->string('storage_req', 100);
            $table->string('remarks', 250)->nullable();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
        /* supplier table */
        Schema::create('suppliers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('phone_no', 100);
            $table->string('email', 100)->nullable();
            $table->string('address');
           
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
        /* inventory-supply table */
        Schema::create('inv_supply', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->string('lot', 100);
            $table->string('batch_no', 12);
            $table->dateTime('expiry_date');
            $table->string('manufacturer', 100)->nullable();
            $table->integer('supplier_id')->unsigned();
            $table->integer('quantity_ordered')->default(0);
            $table->integer('quantity_supplied')->default(0);
            $table->decimal('cost_per_unit', 5, 2)->nullable();
            $table->date('date_of_order')->nullable();
            $table->date('date_of_supply')->nullable();
            $table->date('date_of_reception');
            $table->string('remarks', 250)->nullable();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('inv_items');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
		/* inventory top up requests */
		Schema::create('requests', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('test_category_id')->unsigned();
            $table->integer('order_quantity')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('remarks', 100);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('test_category_id')->references('id')->on('test_categories');
            $table->foreign('item_id')->references('id')->on('inv_items');
            $table->foreign('user_id')->references('id')->on('users');
        });
        /* inventory-usage table */
        Schema::create('inv_usage', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->integer('quantity_used')->default(0);
            $table->date('date_of_usage');
            $table->string('remarks', 250)->nullable();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('stock_id')->references('id')->on('inv_supply');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//	Rollback
		Schema::dropIfExists('inv_usage');
		Schema::dropIfExists('requests');
		Schema::dropIfExists('inv_supply');
		Schema::dropIfExists('suppliers');
		Schema::dropIfExists('inv_items');
	}
}
