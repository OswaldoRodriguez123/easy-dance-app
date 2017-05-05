<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitante extends Model {

	use SoftDeletes;

	protected $table = 'visitantes_presenciales';

}