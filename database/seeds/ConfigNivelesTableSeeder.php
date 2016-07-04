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
	    ));

	    ConfigNiveles::create(array(
	      'nombre' => 'Intermedio',
	    ));

	    ConfigNiveles::create(array(
	      'nombre' => 'Avanzado',
	    ));

	    ConfigNiveles::create(array(
	      'nombre' => 'Master',
	    ));
    }
}
