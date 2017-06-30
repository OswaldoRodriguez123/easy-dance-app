<?php

use Illuminate\Database\Seeder;
use App\Tipologia;

class TipologiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tipologias')->truncate();

  	    Tipologia::create(array(
  	      'nombre' => 'Paquetes de Clases',
  	    ));

  	    Tipologia::create(array(
  	      'nombre' => 'Personalizadas',
  	    ));

  	    Tipologia::create(array(
  	      'nombre' => 'Talento Cuerpo de Formación',
  	    ));

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
