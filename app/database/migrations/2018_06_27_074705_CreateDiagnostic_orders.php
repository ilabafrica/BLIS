<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnostic_orders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		    Schema::create('diagnostic_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('diagnostic_order_status_id')->unsigned()
                ->default(DiagnosticOrderStatus::result_pending);
            $table->integer('test_id')->unsigned();
            $table->integer('test_type_mapping_id')->unsigned()->nullable();
            $table->timestamp('time_sent')->nullable();
            $table->timestamps();
        });

	}

	
	
}
