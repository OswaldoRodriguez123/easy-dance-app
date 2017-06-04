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
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('impuesto')->truncate();

	    Impuesto::create(array(
	      'pais_id' => 1,
	      'impuesto' => 12,
	    ));

        Impuesto::create(array(
          'pais_id' => 2,
          'impuesto' => 12,
        ));

        Impuesto::create(array(
          'pais_id' => 3,
          'impuesto' => 12,
        ));

        Impuesto::create(array(
          'pais_id' => 4,
          'impuesto' => 22,
        ));

        Impuesto::create(array(
          'pais_id' => 5,
          'impuesto' => 21,
        ));

        Impuesto::create(array(
          'pais_id' => 6,
          'impuesto' => 19,
        ));

        Impuesto::create(array(
          'pais_id' => 7,
          'impuesto' => 18,
        ));

        Impuesto::create(array(
          'pais_id' => 8,
          'impuesto' => 18,
        ));

        Impuesto::create(array(
          'pais_id' => 9,
          'impuesto' => 17,
        ));

        Impuesto::create(array(
          'pais_id' => 10,
          'impuesto' => 16,
        ));

        Impuesto::create(array(
          'pais_id' => 11,
          'impuesto' => 16,
        ));

        Impuesto::create(array(
          'pais_id' => 12,
          'impuesto' => 15,
        ));

        Impuesto::create(array(
          'pais_id' => 13,
          'impuesto' => 15,
        ));

        Impuesto::create(array(
          'pais_id' => 14,
          'impuesto' => 13,
        ));

        Impuesto::create(array(
          'pais_id' => 15,
          'impuesto' => 13,
        ));

        Impuesto::create(array(
          'pais_id' => 16,
          'impuesto' => 13,
        ));

        Impuesto::create(array(
          'pais_id' => 17,
          'impuesto' => 11.5,
        ));

        Impuesto::create(array(
          'pais_id' => 18,
          'impuesto' => 10,
        ));

        Impuesto::create(array(
          'pais_id' => 19,
          'impuesto' => 7,
        ));

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
