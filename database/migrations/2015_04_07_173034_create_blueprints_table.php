<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlueprintsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blueprints', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('project_id')->unsigned()->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('code')->index();
            $table->boolean('approved')->default(false)->index();
			$table->enum('type', ['funding', 'sale']);
			$table->string('user_introduction');
			$table->string('project_introduction');
			$table->string('story');
			$table->string('estimated_amount');
			$table->string('contact');
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
