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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('config_egresos')->delete();

  	    ConfigEgreso::create(array(
  	      'nombre' => 'Pasivo',
  	    ));

  	    ConfigEgreso::create(array(
  	      'nombre' => 'Utilidad',
  	    ));

  	    ConfigEgreso::create(array(
  	      'nombre' => 'Costos',
  	    ));

  	    ConfigEgreso::create(array(
  	      'nombre' => 'Viáticos',
  	    ));

        ConfigEgreso::create(array(
          'nombre' => 'Prestamos',
        ));

        ConfigEgreso::create(array(
          'nombre' => 'Comisiones',
        ));

        ConfigEgreso::create(array(
          'nombre' => 'Nómina',
        ));

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
