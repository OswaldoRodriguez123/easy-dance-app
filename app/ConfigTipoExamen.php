<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigTipoExamen extends Model {

	use SoftDeletes;

	protected $table = 'config_tipo_examenes';

}