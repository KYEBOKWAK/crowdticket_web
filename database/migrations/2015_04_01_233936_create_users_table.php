<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('email')->unique();
			$table->string('name');
			$table->string('password');
            $table->bigInteger('facebook_id')->unique()->nullable();
            $table->integer('projects_count')->unsigned()->default(0);
            $table->integer('supports_count')->unsigned()->default(0);
            $table->integer('watches_count')->unsigned()->default(0);
            $table->integer('tickets_count')->unsigned()->default(0);
            $table->integer('followings_count')->unsigned()->default(0);
            $table->integer('followers_count')->unsigned()->default(0);
            $table->string('profile_photo_url')->nullable();
			$table->rememberToken();
			$table->timestamps();
            $table->softDeletes();
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
