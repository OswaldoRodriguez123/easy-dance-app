<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigEstudios extends Model {

	use SoftDeletes;

	protected $table = 'config_estudios';

}