<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionClasePersonalizada extends Model {

	use SoftDeletes;

	protected $table = 'inscripcion_clase_personalizada';
}