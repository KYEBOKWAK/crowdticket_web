<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('ticket_id')->unsigned()->nullable();
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->string('reward')->default('');
            $table->integer('audiences_limit')->unsigned();
            $table->integer('audiences_count')->unsigned()->default(0);
            $table->integer('price')->unsigned();
			$table->integer('real_ticket_count')->unsigned()->default(0);
            $table->boolean('require_shipping')->default(false);
            $table->integer('shipping_charge')->unsigned()->default(0);
            $table->timestamp('delivery_date')->nullable();
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
	    
	}

}
