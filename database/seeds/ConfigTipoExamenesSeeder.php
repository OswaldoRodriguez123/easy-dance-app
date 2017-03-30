<?php

use Illuminate\Database\Seeder;
use App\ConfigTipoExamen;

class ConfigTipoExamenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
        DB::table('config_tipo_examenes')->delete();

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Evaluacion',
	      'academia_id' => null,

	    ));

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Clase personalizada',
	      'academia_id' => null,

	    ));

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Casting',
	      'academia_id' => null,

	    ));

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Otros',
	      'academia_id' => null,

	    ));

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Diagnostico de Ingreso',
	      'academia_id' => null,

	    ));

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Valoración Recurrente',
	      'academia_id' => null,

	    ));
    }
}
