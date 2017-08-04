<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioTaller extends Model
{
	use SoftDeletes;
    protected $table = 'horarios_talleres';
}