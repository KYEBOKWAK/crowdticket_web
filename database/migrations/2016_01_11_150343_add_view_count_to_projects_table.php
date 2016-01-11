<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddViewCountToProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('projects', function(Blueprint $table) {
			$table->integer('view_count')->unsigned()->default(0)->after('tickets_count');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('projects', function(Blueprint $table) {
			//
		});
	}

}
