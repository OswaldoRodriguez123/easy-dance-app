<?php

use Illuminate\Database\Seeder;
use App\ConfigCoreografias;

class ConfigCoreografiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('config_coreografias')->delete();

	    ConfigCoreografias::create(array(
	      'nombre' => 'Solista',

	    ));

	    ConfigCoreografias::create(array(
	      'nombre' => 'Pareja',

	    ));

	    ConfigCoreografias::create(array(
	      'nombre' => 'Dúo',

	    ));

	    ConfigCoreografias::create(array(
	      'nombre' => 'Grupal',

	    ));

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

