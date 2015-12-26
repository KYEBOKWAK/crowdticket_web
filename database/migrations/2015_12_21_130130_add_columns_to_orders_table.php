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
			$table->string('postcode')->default('');
			$table->string('address_main')->default('');
			$table->string('address_detail')->default('');
			$table->string('requirement')->default('');
			$table->string('refund_name');
			$table->string('refund_bank');
			$table->string('refund_account');
			$table->boolean('confirmed')->default(false);
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
