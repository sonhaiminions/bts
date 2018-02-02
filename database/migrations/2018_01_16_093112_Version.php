<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Version extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('version', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('app_id')->unsigned();
			$table->foreign('app_id')->references('id')->on('app')->onDelete('cascade');
			$table->string('version', 50);
			$table->text('newfeature');
			$table->string('link', 50);
			$table->integer('permission');
			$table->integer('admin_id')->unsigned();
			$table->foreign('admin_id')->references('id')->on('admin');
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
		Schema::dropIfExists('version');
	}
}
