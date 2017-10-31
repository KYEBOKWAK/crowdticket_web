<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionToTickets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets', function($table) {
	        $table->string('question')->after('shipping_charge');
	        $table->boolean('require_question')->default(true)->after('question');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tickets', function($table) {
	        $table->dropColumn('paid');
	        $table->dropColumn('require_question');
	    });
	}

}
