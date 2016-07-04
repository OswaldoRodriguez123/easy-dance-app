<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Fiesta extends Model {

	use SoftDeletes;

	protected $table = 'fiestas';

}