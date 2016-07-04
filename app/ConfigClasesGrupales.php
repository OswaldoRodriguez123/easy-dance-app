<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigClasesGrupales extends Model {

	use SoftDeletes;

	protected $table = 'config_clases_grupales';

}