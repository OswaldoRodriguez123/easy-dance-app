<?php

use Illuminate\Database\Seeder;
use App\ConfigBoletos;

class ConfigBoletosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_boletos')->delete();

	    ConfigBoletos::create(array(
	      'nombre' => 'General',

	    ));

	    ConfigBoletos::create(array(
	      'nombre' => 'Vip',
	      
	    ));

	    ConfigBoletos::create(array(
	      'nombre' => 'Premium',
	      
	    ));

	    ConfigBoletos::create(array(
	      'nombre' => 'Gold',
	      
	    ));

	    ConfigBoletos::create(array(
	      'nombre' => 'Platinum',
	      
	    ));

	    ConfigBoletos::create(array(
	      'nombre' => 'Cortesía',
	      
	    ));

    }
}
