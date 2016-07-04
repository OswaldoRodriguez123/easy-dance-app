<?php

use Illuminate\Database\Seeder;
use App\DiasDeSemana;

class DiasDeSemanaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('dias_de_semana')->delete();

	    DiasDeSemana::create(array(
	      'nombre' => 'Lunes',
	    ));

	   	DiasDeSemana::create(array(
	      'nombre' => 'Martes',
	    ));

	    DiasDeSemana::create(array(
	      'nombre' => 'Míercoles',
	    ));
	   	DiasDeSemana::create(array(
	      'nombre' => 'Jueves',
	    ));

	  	DiasDeSemana::create(array(
	      'nombre' => 'Viernes',
	    ));

	    DiasDeSemana::create(array(
	      'nombre' => 'Sábado',
	    ));

	    DiasDeSemana::create(array(
	      'nombre' => 'Domingo',
	    ));
    }
}
