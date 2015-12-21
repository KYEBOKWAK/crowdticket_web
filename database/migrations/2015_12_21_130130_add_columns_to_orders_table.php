<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->integer('price')->unsigned();
			$table->string('account_name');
			$table->string('name');
			$table->string('email');
			$table->string('postcode');
			$table->string('address_main');
			$table->string('address_detail');
			$table->string('requirement');
			$table->string('refund_name');
			$table->string('refund_bank');
			$table->string('refund_account');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			//
		});
	}

}
