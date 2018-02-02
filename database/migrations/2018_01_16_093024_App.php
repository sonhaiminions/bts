<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class App extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('app', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 50);
			$table->string('icon', 50);
			$table->text('describ');
			$table->string('hdh', 50);
			$table->string('publisher', 50);
			$table->string('api_token', 50);
			$table->integer('admin_id');
			$table->integer('status');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('app');
	}
}
