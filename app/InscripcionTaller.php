<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class InscripcionTaller extends Model {

	use SoftDeletes;

	protected $table = 'inscripcion_taller';

}