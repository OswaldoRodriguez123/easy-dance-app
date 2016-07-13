<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('instructores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
			$table->string('identificacion',20)->unique();
			$table->string('nombre',15);
			$table->string('apellido',15);
			$table->date('fecha_nacimiento');
			$table->string('sexo',30);
			$table->string('correo');
			$table->string('telefono',11);
			$table->string('celular',11);
			$table->string('direccion',200);
			$table->string('experiencia_artistica',20);
			$table->string('experiencia_laboral',20);
			$table->string('nivel',50);
			$table->string('especialidad',50);
			$table->string('observacion',300);
			$table->boolean('asma')->default(0);
			$table->boolean('alergia')->default(0);
			$table->boolean('convulsiones')->default(0);
			$table->boolean('cefalea')->default(0);
			$table->boolean('hipertension')->default(0);
			$table->boolean('lesiones')->default(0);
			$table->boolean('estatus')->default(1);
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
		Schema::drop('instructores');
	}

}
