<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Version extends Model {

	protected $table = 'version';
	protected $fillable = ['app_id', 'version', 'newfeature', 'link', 'permission', 'admin_id', 'status'];
	// protected $hidden = [];
}