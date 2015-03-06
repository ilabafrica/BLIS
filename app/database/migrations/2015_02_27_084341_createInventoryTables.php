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
        Schema::create('inventory_metrics', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('description', 100);
              
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('inventory_commodities', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('description', 100);
            $table->integer('inventory_metrics_id')->unsigned();
            $table->decimal('unit_price', 8,2);
            $table->string('item_code', 100);
            $table->string('storage_req', 100);
            $table->integer('min_level');
            $table->integer('max_level');

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('inventory_metrics_id')->references('id')->on('inventory_metrics');
        });

        Schema::create('inventory_suppliers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('phone_no', 100);
            $table->string('email', 100);
            $table->string('physical_address');
           
            $table->softDeletes();
            $table->timestamps();
        });

		Schema::create('inventory_receipts', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->date('receipt_date');
            $table->integer('inventory_commodity_id')->unsigned();
            $table->integer('inventory_metrics_id')->unsigned();
            $table->integer('inventory_suppliers_id')->unsigned();
            $table->string('doc_no', 100);
            $table->integer('qty')->unsigned();
            $table->integer('batch_no')->unsigned();
            $table->date('expiry_date');
            $table->string('location', 100);
            $table->string('receivers_name', 100);
            $table->integer('user_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('inventory_commodity_id')->references('id')->on('inventory_commodities');
            $table->foreign('inventory_metrics_id')->references('id')->on('inventory_metrics');
            $table->foreign('inventory_suppliers_id')->references('id')->on('inventory_suppliers');
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::create('inventory_issues', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->date('issue_date');
            $table->string('doc_no', 100);
            $table->integer('inventory_commodity_id')->unsigned();
            $table->date('expiry_date');
            $table->integer('batch_no')->unsigned();
            $table->integer('qty_avl')->unsigned();
            $table->integer('qty_req')->unsigned();
            $table->string('destination', 100);
            $table->string('receivers_name', 100);
            $table->integer('stock_balance')->unsigned();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('inventory_commodity_id')->references('id')->on('inventory_commodities');
        });
        
        Schema::create('inventory_stocktake', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->date('period_beginning');
            $table->date('period_ending');
            $table->string('code', 100);
            $table->integer('inventory_commodity_id')->unsigned();
            $table->integer('batch_no')->unsigned();
            $table->date('expiry_date');
            $table->integer('stock_balance')->unsigned();
            $table->integer('physical_count')->unsigned();
            $table->integer('unit_price')->unsigned();
            $table->integer('total_price')->unsigned();
            $table->string('discrepancy', 100);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('inventory_commodity_id')->references('id')->on('inventory_commodities');
        });

        Schema::create('inventory_labtopup', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('inventory_commodity_id')->unsigned();
            $table->string('inventory_metrics_id', 100);
            $table->integer('current_bal')->unsigned();
            $table->string('tests_done', 100);
            $table->integer('order_qty')->unsigned();
            $table->integer('issue_qty')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('receivers_name', 100);
            $table->string('remarks', 100);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('inventory_commodity_id')->references('id')->on('inventory_commodities');
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
        Schema::dropIfExists('inventory_suppliers');
        Schema::dropIfExists('inventory_labtopup');
        Schema::dropIfExists('inventory_stocktake');
        Schema::dropIfExists('inventory_issues');
        Schema::dropIfExists('inventory_receipts');
        Schema::dropIfExists('inventory_commodities');
        Schema::dropIfExists('inventory_metrics');
	}

}
