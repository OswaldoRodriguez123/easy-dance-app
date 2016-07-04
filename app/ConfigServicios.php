<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigServicios extends Model {

	use SoftDeletes;

	protected $table = 'config_servicios';

}