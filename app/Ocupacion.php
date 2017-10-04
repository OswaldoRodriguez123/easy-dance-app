<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ocupacion extends Model {

	use SoftDeletes;

	protected $table = 'ocupaciones';

}