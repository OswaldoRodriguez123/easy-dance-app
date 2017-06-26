<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConceptoSupervision extends Model {

	use SoftDeletes;

	protected $table = 'conceptos_supervisiones';

}