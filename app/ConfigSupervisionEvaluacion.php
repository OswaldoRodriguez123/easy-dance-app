<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigSupervisionEvaluacion extends Model {

	use SoftDeletes;

	protected $table = 'config_supervisiones_evaluaciones';

}