<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthStoreTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('oauth_store', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('token_key');
            $table->string('token_secret');
            $table->tinyInteger('token_is_access');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('oauth_store');
    }
}
