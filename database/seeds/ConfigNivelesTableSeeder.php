<?php

use Illuminate\Database\Seeder;
use App\ConfigNiveles;

class ConfigNivelesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('config_niveles_baile')->delete();

		ConfigNiveles::create(array(
	      'nombre' => 'Básico',
	      'academia_id' => null,
	    ));

	    ConfigNiveles::create(array(
	      'nombre' => 'Intermedio',
	      'academia_id' => null,
	    ));

	    ConfigNiveles::create(array(
	      'nombre' => 'Avanzado',
	      'academia_id' => null,
	    ));

	    ConfigNiveles::create(array(
	      'nombre' => 'Master',
	      'academia_id' => null,
	    ));
    }
}
