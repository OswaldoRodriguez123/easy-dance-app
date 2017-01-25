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

	    ));

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Clase personalizada',

	    ));

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Casting',

	    ));

	    ConfigTipoExamen::create(array(
	      'nombre' => 'Otros',

	    ));
    }
}
