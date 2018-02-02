<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user', function (Blueprint $table) {
			$table->increments('id');
			$table->string('username', 50);

			$table->string('password', 255);
			$table->string('fullname', 50);
			$table->string('avatar', 50);
			$table->string('email', 50);
			$table->integer('phone');
			$table->string('api_token', 100);
			$table->timestamps();
			$table->integer('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user');
	}
}
