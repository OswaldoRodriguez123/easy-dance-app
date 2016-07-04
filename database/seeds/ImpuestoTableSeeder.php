<?php

use Illuminate\Database\Seeder;
use App\Impuesto;

class ImpuestoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('impuesto')->delete();

	    Impuesto::create(array(
	      'pais_id' => 1,
	      'impuesto' => 12,
	    ));
    }
}
