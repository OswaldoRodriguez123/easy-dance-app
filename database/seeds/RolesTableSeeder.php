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
        DB::table('roles')->delete();

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
	      'name' => 'recepcionista',
	      'display_name' => 'Recepcionista',
	      'description' => 'Rol Recepcionista'
	    ));

    }
}
