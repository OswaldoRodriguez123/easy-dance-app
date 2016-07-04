<?php

use Illuminate\Database\Seeder;
use App\DiasDeInteres;

class DiasDeInteresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dias_de_interes')->delete();

	    DiasDeInteres::create(array(
	      'nombre' => 'Dias de Semana',
	    ));

	    DiasDeInteres::create(array(
	      'nombre' => 'Fin de Semana',
	    ));

	    DiasDeInteres::create(array(
	      'nombre' => 'Ambos',
	    ));

    }
}
