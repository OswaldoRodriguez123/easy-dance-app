<?php

use Illuminate\Database\Seeder;
use App\Gravedad;

class GravedadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('gravedades')->truncate();

  	    Gravedad::create(array(
  	      'nombre' => 'Leve',
  	    ));

  	    Gravedad::create(array(
  	      'nombre' => 'Intermedia',
  	    ));

  	    Gravedad::create(array(
  	      'nombre' => 'Grave',
  	    ));

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
