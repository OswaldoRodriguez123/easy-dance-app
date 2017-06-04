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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('items_examenes')->truncate();

	    ItemsExamenes::create(array(
	      'nombre' => 'Tiempos musicales',
	      'academia_id' => null,
	    ));

	   	ItemsExamenes::create(array(
	      'nombre' => 'Habilidades',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Destreza',
	      'academia_id' => null,
	    ));
	   	ItemsExamenes::create(array(
	      'nombre' => 'Postura',
	      'academia_id' => null,
	    ));

	  	ItemsExamenes::create(array(
	      'nombre' => 'Elasticidad',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Asistencia',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Compromiso',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Disciplina',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Dedicación',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Respeto',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Complejidad de movimientos',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Estilo',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Condiciones',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Expresión corporal',
	      'academia_id' => null,
	    ));

	    ItemsExamenes::create(array(
	      'nombre' => 'Oído musical',
	      'academia_id' => null,
	    ));

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
