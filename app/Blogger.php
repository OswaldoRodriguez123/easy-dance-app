<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blogger extends Model {

	use SoftDeletes;

	protected $table = 'bloggers';

}