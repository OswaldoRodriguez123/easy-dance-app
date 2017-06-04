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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('dias_de_interes')->truncate();

	    DiasDeInteres::create(array(
	      'nombre' => 'Dias de Semana',
	    ));

	    DiasDeInteres::create(array(
	      'nombre' => 'Fin de Semana',
	    ));

	    DiasDeInteres::create(array(
	      'nombre' => 'Ambos',
	    ));

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
