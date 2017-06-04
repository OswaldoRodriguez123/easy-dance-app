<?php

use Illuminate\Database\Seeder;
use App\TipoEgreso;

class TiposEgresosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tipos_egresos')->truncate();

  	    TipoEgreso::create(array(
  	      'nombre' => 'Academia',
  	    ));

  	    TipoEgreso::create(array(
  	      'nombre' => 'Eventos',
  	    ));

  	    TipoEgreso::create(array(
  	      'nombre' => 'Talleres',
  	    ));

  	    TipoEgreso::create(array(
  	      'nombre' => 'Campañas',
  	    ));

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
