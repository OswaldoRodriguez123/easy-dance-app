<?php

use Illuminate\Database\Seeder;
use App\FormasPago;

class FormasPagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('formas_pago')->truncate();

	    FormasPago::create(array(
	      'nombre' => 'Efectivo',
	    ));

	   	FormasPago::create(array(
	      'nombre' => 'Debito',
	    ));

	    FormasPago::create(array(
	      'nombre' => 'Credito',
	    ));

	    FormasPago::create(array(
	      'nombre' => 'Puntos Acumulados',
	    ));

	    FormasPago::create(array(
	      'nombre' => 'Cheques',
	    ));

	    FormasPago::create(array(
	      'nombre' => 'Otros',
	    ));

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}