<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigProductos extends Model {

	use SoftDeletes;

	protected $table = 'config_productos';

}