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
		Schema::create('inventory_receipts', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->date('receipt_date');
            $table->integer('commodity_id')->unsigned();
            $table->integer('unit_of_issue')->unsigned();
            $table->integer('received_from')->unsigned();
            $table->string('doc_no', 100);
            $table->integer('qty')->unsigned();
            $table->integer('batch_no')->unsigned();
            $table->date('expiry_date');
            $table->string('location', 100);
            $table->string('receivers_name', 100);
            $table->integer('user_id')->unsigned();
                    
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('commodity_id')->references('id')->on('inventory_commodity');
            $table->foreign('unit_of_issue')->references('id')->on('inventory_metrics');
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::create('inventory_issues', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->date('issue_date');
            $table->string('doc_no', 100);
            $table->integer('commodity_id')->unsigned();
            $table->date('expiry_date');
            $table->integer('batch_no')->unsigned();
            $table->integer('qty_avl')->unsigned();
            $table->integer('qty_req')->unsigned();
            $table->string('destination', 100);
            $table->string('receivers_name', 100);
            $table->integer('stock_balance')->unsigned();
                         
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('commodity_id')->references('id')->on('inventory_receipts');
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
            $table->foreign('commodity_id')->references('id')->on('inventory_receipts');
       
        });


        Schema::create('inventory_labtopup', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->date('date');
            $table->integer('commodity_id')->unsigned();
            $table->string('unit_of_issue', 100);
            $table->integer('current_bal')->unsigned();
            $table->string('tests_done', 100);
            $table->integer('order_qty')->unsigned();
            $table->integer('issue_qty')->unsigned();
            $table->integer('issued_by')->unsigned();
            $table->string('receivers_name', 100);
            $table->string('remarks', 100);

                                     
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('commodity_id')->references('id')->on('inventory_receipts');
            $table->foreign('issued_by')->references('id')->on('users');
       
        });

        Schema::create('inventory_metrics', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('description', 100);
              
            $table->softDeletes();
            $table->timestamps();
                  
        });

        Schema::create('inventory_commodity', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('commodity', 100);
            $table->string('description', 100);
            $table->integer('unit_of_issue')->unsigned();
            $table->decimal('unit_price', 8,2);
            $table->string('item_code', 100);
            $table->string('storage_req', 100);
            $table->integer('min_level');
            $table->integer('max_level');
                      

                                     
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('unit_of_issue')->references('id')->on('inventory_metrics');
           
       
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
