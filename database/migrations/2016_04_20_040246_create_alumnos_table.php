<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alumnos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
			$table->string('identificacion',20);
			$table->string('nombre',15);
			$table->string('apellido',15);
			$table->date('fecha_nacimiento');
			$table->string('sexo',15);
			$table->string('correo',30);
			$table->string('telefono',11);
			$table->string('celular',11);
			$table->string('imagen');
			$table->string('direccion',180);
			$table->boolean('asma')->default(0);
			$table->boolean('alergia')->default(0);
			$table->boolean('convulsiones')->default(0);
			$table->boolean('cefalea')->default(0);
			$table->boolean('hipertension')->default(0);
			$table->boolean('lesiones')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alumnos');
	}

}
