<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservacionVisitante extends Model {

	use SoftDeletes;

	protected $table = 'reservaciones_visitantes';

}