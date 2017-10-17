<?php

use Illuminate\Database\Seeder;
use App\AsuntoLlamada;

class LlamadaAsuntoSeeder extends Seeder
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

  	    AsuntoLlamada::create(array(
  	      'nombre' => 'Inasistencia a clases',
  	    ));

  	    AsuntoLlamada::create(array(
  	      'nombre' => 'Ofrecimiento de un servicio',
  	    ));

  	    AsuntoLlamada::create(array(
  	      'nombre' => 'Información especial',
  	    ));

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
