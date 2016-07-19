<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('test_id')->unsigned();
            $table->integer('current_amount');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('payments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('charge_id')->unsigned();
            $table->integer('full_amount');
            $table->integer('amount_paid');

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
