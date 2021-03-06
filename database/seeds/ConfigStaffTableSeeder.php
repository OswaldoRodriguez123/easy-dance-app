<?php

use Illuminate\Database\Seeder;
use App\ConfigStaff;

class ConfigStaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('config_staff')->delete();

  	  ConfigStaff::create(array(
        'nombre' => 'Promotor',
        'academia_id' => null,
      ));

      ConfigStaff::create(array(
        'nombre' => 'Recepcionista',
        'academia_id' => null,
      ));

      ConfigStaff::create(array(
        'nombre' => 'Administrador',
        'academia_id' => null,
      ));

      ConfigStaff::create(array(
        'nombre' => 'Coordinador de Pista',
        'academia_id' => null,
      ));

      ConfigStaff::create(array(
        'nombre' => 'Mantenimiento',
        'academia_id' => null,
      ));

      ConfigStaff::create(array(
        'nombre' => 'Seguridad',
        'academia_id' => null,
      ));

      ConfigStaff::create(array(
        'nombre' => 'Gerente General',
        'academia_id' => null,
      ));

      ConfigStaff::create(array(
        'nombre' => 'Relacionista Público',
        'academia_id' => null,
      ));

      ConfigStaff::create(array(
        'id' => 20,
        'nombre' => 'Instructor',
        'academia_id' => null,
      ));

      DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}