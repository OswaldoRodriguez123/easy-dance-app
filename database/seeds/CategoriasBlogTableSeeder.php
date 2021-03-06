<?php

use Illuminate\Database\Seeder;
use App\CategoriaBlog;

class CategoriasBlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
    	DB::table('categorias_blog')->truncate();

		CategoriaBlog::create(array(
	      'nombre' => 'Nuevas Aperturas',
	      'academia_id' => null,
	    ));

	    CategoriaBlog::create(array(
	      'nombre' => 'Novedades',
	      'academia_id' => null,
	    ));

	    CategoriaBlog::create(array(
	      'nombre' => 'Eventos',
	      'academia_id' => null,
	    ));

	    CategoriaBlog::create(array(
	      'nombre' => 'Talleres',
	      'academia_id' => null,
	    ));

	    CategoriaBlog::create(array(
	      'nombre' => 'Testimonios',
	      'academia_id' => null,
	    ));

	    CategoriaBlog::create(array(
	      'nombre' => 'Nuestro Equipo de Trabajo',
	      'academia_id' => null,
	    ));

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
