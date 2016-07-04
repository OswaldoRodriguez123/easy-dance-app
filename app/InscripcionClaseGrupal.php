<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class InscripcionClaseGrupal extends Model {

	use SoftDeletes;

	protected $table = 'inscripcion_clase_grupal';

}