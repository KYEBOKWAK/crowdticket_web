<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropColumn('account_name');
			$table->dropColumn('refund_name');
			$table->dropColumn('refund_bank');
			$table->dropColumn('refund_account');
			$table->dropColumn('confirmed')->default(false);
			$table->string('imp_meta');
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
