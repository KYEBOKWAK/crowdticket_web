<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('category_id')->unsigned()->default(0);
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('city_id')->unsigned()->default(0);
            $table->foreign('city_id')->references('id')->on('cities');
            $table->integer('organization_id')->unsigned()->nullable();
            $table->foreign('organization_id')->references('id')->on('organizations');
			$table->enum('type', ['funding', 'sale'])->index();
			$table->tinyInteger('state')->default(1)->index();
            $table->boolean('published')->default(false)->index();
            $table->string('title')->default('')->index();
			$table->string('alias')->default('')->unique();
            $table->string('poster_url')->default('');
			$table->string('description')->default('');
			$table->string('video_url')->default('');
            $table->string('detailed_address')->default('');
            $table->integer('pledged_amount')->unsigned()->default(0);
            $table->integer('funded_amount')->unsigned()->default(0);
            $table->integer('audiences_limit')->unsigned()->default(0);
            $table->integer('audiences_count')->unsigned()->default(0);
            $table->integer('news_count')->unsigned()->default(0);
            $table->integer('supporters_count')->unsigned()->default(0);
            $table->integer('comments_count')->unsigned()->default(0);
			$table->timestamps();
            $table->timestamp('funding_closing_at')->nullable();
            $table->timestamp('performance_opening_at')->nullable();
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
