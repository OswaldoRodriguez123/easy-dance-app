<?php

use Illuminate\Database\Seeder;
use App\ConfigTipoExamen;

class ConfigTipoExamenesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('config_tipo_examenes')->truncate();

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

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
