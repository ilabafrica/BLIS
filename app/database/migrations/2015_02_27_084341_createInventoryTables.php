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
        
        Schema::create('issues', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('commodity_id')->unsigned();
            $table->integer('receipt_id');
            $table->integer('quantity_issued');
            $table->integer('test_category_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('test_category_id')->references('id')->on('test_categories');
            $table->foreign('commodity_id')->references('id')->on('commodities');
            $table->foreign('receipt_id')->references('id')->on('receipts');
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::create('inventory_stocktake', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->date('period_beginning');
            $table->date('period_ending');
            $table->string('code', 100);
            $table->integer('commodity_id')->unsigned();
            $table->integer('batch_no')->unsigned();
            $table->date('expiry_date');
            $table->integer('stock_balance')->unsigned();
            $table->integer('physical_count')->unsigned();
            $table->integer('unit_price')->unsigned();
            $table->integer('total_price')->unsigned();
            $table->string('discrepancy', 100);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('commodity_id')->references('id')->on('commodities');
        });

        Schema::create('topups', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('commodity_id')->unsigned();
            $table->integer('current_bal')->unsigned();
            $table->string('tests_done', 100);
            $table->integer('order_qty')->unsigned();
            $table->integer('issue_qty')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('receivers_name', 100);
            $table->string('remarks', 100);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('commodity_id')->references('id')->on('commodities');
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
        Schema::dropIfExists('topups');
        Schema::dropIfExists('inventory_stocktake');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('commodities');
        Schema::dropIfExists('metrics');
	}

}
