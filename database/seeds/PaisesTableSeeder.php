<?php

use Illuminate\Database\Seeder;
use App\Paises;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paises')->delete();

	    Paises::create(array(
	      'nombre' => 'Venezuela',
	      'moneda' => 'Bs'
	    ));

	    Paises::create(array(
	      'nombre' => 'Guatemala',
	    ));

	    Paises::create(array(
	      'nombre' => 'Ecuador',
	    ));

	    Paises::create(array(
	      'nombre' => 'Uruguay',
	    ));

	    Paises::create(array(
	      'nombre' => 'Argentina',
	    ));

	    Paises::create(array(
	      'nombre' => 'Chile',
	    ));

	    Paises::create(array(
	      'nombre' => 'Perú',
	    ));

	    Paises::create(array(
	      'nombre' => 'República dominicana',
	    ));

	    Paises::create(array(
	      'nombre' => 'Brazil',
	    ));

	    Paises::create(array(
	      'nombre' => 'México',
	    ));

	    Paises::create(array(
	      'nombre' => 'Colombia',
	    ));

	    Paises::create(array(
	      'nombre' => 'Honduras',
	    ));

	    Paises::create(array(
	      'nombre' => 'Nicaragua',
	    ));

	    Paises::create(array(
	      'nombre' => 'Bolivia',
	    ));

	    Paises::create(array(
	      'nombre' => 'Costa rica',
	    ));

	    Paises::create(array(
	      'nombre' => 'El salvador',
	    ));

	    Paises::create(array(
	      'nombre' => 'Puerto rico',
	    ));

	    Paises::create(array(
	      'nombre' => 'Paraguay',
	    ));

	    Paises::create(array(
	      'nombre' => 'Panamá',

	    ));
    }
}
