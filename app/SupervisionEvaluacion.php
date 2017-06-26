<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupervisionEvaluacion extends Model {

	use SoftDeletes;

	protected $table = 'supervisiones_evaluaciones';

}