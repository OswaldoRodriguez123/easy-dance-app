<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasePersonalizada extends Model {

	use SoftDeletes;

	protected $table = 'clases_personalizadas';

}