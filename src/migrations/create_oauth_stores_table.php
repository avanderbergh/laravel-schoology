<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_store', function(Blueprint $table)
		{
			$table->unsignedInteger('id')->primary();
            $table->string('token_key');
            $table->string('token_secret');
            $table->tinyInteger('token_is_access');
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
		Schema::drop('oauth_store');
	}

}
