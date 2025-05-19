<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
	protected $fillable = ['name', 'address', 'email', 'phone', 'archived'];

	protected $hidden = ['created_at', 'updated_at'];
}
