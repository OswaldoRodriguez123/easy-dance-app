<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigNiveles extends Model {

	use SoftDeletes;

	protected $table = 'config_niveles_baile';

}