<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('metrics', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('description', 100);
              
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('commodities', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('description', 100);
            $table->integer('metric_id')->unsigned();
            $table->decimal('unit_price', 8,2);
            $table->string('item_code', 100);
            $table->string('storage_req', 100);
            $table->integer('min_level');
            $table->integer('max_level');

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('metric_id')->references('id')->on('metrics');
        });

        Schema::create('suppliers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('phone_no', 100);
            $table->string('email', 100);
            $table->string('physical_address');
           
            $table->softDeletes();
            $table->timestamps();
        });

		Schema::create('receipts', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('commodity_id')->unsigned();
            $table->integer('supplier_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->string('batch_no', 12);
            $table->date('expiry_date');
            $table->integer('user_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('commodity_id')->references('id')->on('commodities');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('topup_requests', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('commodity_id')->unsigned();
            $table->integer('test_category_id')->unsigned();
            $table->integer('order_quantity')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('remarks', 100);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('test_category_id')->references('id')->on('test_categories');
            $table->foreign('commodity_id')->references('id')->on('commodities');
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::create('issues', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('receipt_id')->unsigned();
            $table->integer('topup_request_id')->unsigned();
            $table->integer('quantity_issued');
            $table->integer('issued_to')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('remarks', 400)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('topup_request_id')->references('id')->on('topup_requests');
            $table->foreign('receipt_id')->references('id')->on('receipts');
            $table->foreign('issued_to')->references('id')->on('users');
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
        Schema::dropIfExists('issues');
        Schema::dropIfExists('topup_requests');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('commodities');
        Schema::dropIfExists('metrics');
	}

}
