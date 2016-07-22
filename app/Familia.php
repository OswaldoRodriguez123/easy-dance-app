<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Familia extends Model {

	use SoftDeletes;

	protected $table = 'familias';

}