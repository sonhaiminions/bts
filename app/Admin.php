<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Admin extends Model {

	protected $table = 'admin';
	protected $fillable = ['username', 'password', 'avatar', 'fullname', 'api_token', 'phone', 'status', 'email'];
	protected $hidden = ['password'];
}