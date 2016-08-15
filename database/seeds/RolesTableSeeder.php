<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement("SET FOREIGN_KEY_CHECKS = 0;");

        DB::table('roles')->truncate();

   	    Role::create(array(
	      'name' => 'admin',
	      'display_name' => 'Administrador',
	      'description' => 'Rol Administrador'
	    ));

   	    Role::create(array(
	      'name' => 'alumno',
	      'display_name' => 'Alumnos',
	      'description' => 'Rol Alumnos'
	    ));

   	    Role::create(array(
	      'name' => 'instructor',
	      'display_name' => 'Instructor',
	      'description' => 'Rol Instructor'
	    ));	    

   	    Role::create(array(
	      'name' => 'representante',
	      'display_name' => 'Representante',
	      'description' => 'Rol Representante'
	    ));

   	    Role::create(array(
	      'name' => 'sucursal',
	      'display_name' => 'Sucursal',
	      'description' => 'Rol Sucursal'
	    ));

   	    Role::create(array(
	      'name' => 'recepcionista',
	      'display_name' => 'Recepcionista',
	      'description' => 'Rol Recepcionista'
	    ));

   	    Role::create(array(
	      'name' => 'programadores',
	      'display_name' => 'Programadores',
	      'description' => 'Rol Programadores'
	    ));

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
