<?php

use Illuminate\Database\Seeder;
use App\ConfigEgreso;

class ConfigEgresosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_egresos')->delete();

  	    ConfigEgreso::create(array(
  	      'nombre' => 'Pasivo',
  	    ));

  	    ConfigEgreso::create(array(
  	      'nombre' => 'Inversión',
  	    ));

  	    ConfigEgreso::create(array(
  	      'nombre' => 'Gastos Recurrentes',
  	    ));

  	    ConfigEgreso::create(array(
  	      'nombre' => 'Viáticos',
  	    ));
    }
}
