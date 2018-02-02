<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(App\App::class, function (Faker $faker) {
	return [
		'name' => 'contra' . str_random(5),
		'icon' => 'icon.png',
		'describ' => 'Chung ta khong thuoc ve nhau',
		'hdh' => 'Androi 5.5',
		'api_token' => str_random(20),
		'publisher' => 'Vina gau',
		'icon' => 'icon/icon.png',
		'status' => 1,
		'admin_id' => 1,

	];
});
