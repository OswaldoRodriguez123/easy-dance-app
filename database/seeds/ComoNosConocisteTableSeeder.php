<?php

use Illuminate\Database\Seeder;
use App\ComoNosConociste;

class ComoNosConocisteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_como_nos_conociste')->delete();

	    ComoNosConociste::create(array(
	      'nombre' => 'Por un amigo',
	    ));

	   	ComoNosConociste::create(array(
	      'nombre' => 'Redes sociales / internet',
	    ));

	    ComoNosConociste::create(array(
	      'nombre' => 'Prensa',
	    ));
	   	ComoNosConociste::create(array(
	      'nombre' => 'Televisión',
	    ));

	  	ComoNosConociste::create(array(
	      'nombre' => 'Radio',
	    ));

	    ComoNosConociste::create(array(
	      'nombre' => 'Otros',
	    ));

    }
}
