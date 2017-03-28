<?php

use Illuminate\Database\Seeder;
use App\FormasPago;

class FormasPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('formas_pago')->delete();

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

    }
}