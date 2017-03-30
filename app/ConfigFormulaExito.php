<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigFormulaExito extends Model {

	use SoftDeletes;

	protected $table = 'config_formulas_exito';

}