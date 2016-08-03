<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioClaseGrupal extends Model
{
	use SoftDeletes;
    protected $table = 'horario_clase_grupales';
}
