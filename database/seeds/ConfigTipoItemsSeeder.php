<?php

use Illuminate\Database\Seeder;
use App\ConfigTipoItems;

class ConfigTipoItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_tipo_items')->delete();

	    ConfigTipoItems::create(array(
	      'nombre' => 'Servicio',

	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Producto',
	      
	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Inscripcion Clase Grupal',
	      
	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Cuota Clase Grupal',
	      
	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Inscripcion Taller',
	      
	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Acuerdo',
	      
	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Remanente',
	      
	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Mora',
	      
	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Inscripcion Clase Personalizada',
	      
	    ));

	    ConfigTipoItems::create(array(
	      'nombre' => 'Regalo',
	      
	    ));
	}
}
