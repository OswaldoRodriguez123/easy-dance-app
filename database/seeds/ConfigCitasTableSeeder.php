<?php

use Illuminate\Database\Seeder;
use App\ConfigCitas;

class ConfigCitasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_citas')->delete();

	    ConfigCitas::create(array(
	      'nombre' => 'Diagnóstico',
	    ));

	    ConfigCitas::create(array(
	      'nombre' => 'Asesoría de eventos',
	    ));

	    ConfigCitas::create(array(
	      'nombre' => 'Clases personalizadas',
	    ));

    }
}
