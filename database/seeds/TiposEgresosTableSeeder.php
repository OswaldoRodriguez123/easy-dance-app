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
        DB::table('tipos_egresos')->delete();

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
    }
}
