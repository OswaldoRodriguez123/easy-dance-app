<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\ItemsExamenes;

class ItemsExamenesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items_examenes')->delete();

	    ItemsExamenes::create(array(
	      'nombre' => 'Tiempos musicales',
	    ));

	   	ItemsExamenes::create(array(
	      'nombre' => 'Habilidades',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Destreza',
	    ));
	   	ItemsExamenes::create(array(
	      'nombre' => 'Postura',
	    ));

	  	ItemsExamenes::create(array(
	      'nombre' => 'Elasticidad',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Asistencia',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Compromiso',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Disciplina',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Dedicación',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Respeto',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Complejidad de movimientos',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Estilo',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Condiciones',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Expresión corporal',
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Oído musical',
	    ));

    }
}
