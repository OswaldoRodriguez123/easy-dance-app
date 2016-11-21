<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioClasePersonalizada extends Model
{
	use SoftDeletes;
    protected $table = 'horarios_clases_personalizadas';
}
