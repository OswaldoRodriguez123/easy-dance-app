<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNombreApellidoParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {

            $table->string('nombre')->change();
            $table->string('apellido')->change();

            
        });

        Schema::table('instructores', function (Blueprint $table) {

            $table->string('nombre')->change();
            $table->string('apellido')->change();
            
        });

        Schema::table('visitantes_presenciales', function (Blueprint $table) {

            $table->string('nombre')->change();
            $table->string('apellido')->change();
            
        });

        Schema::table('proveedores', function (Blueprint $table) {

            $table->string('nombre')->change();
            $table->string('apellido')->change();
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {

            $table->string('nombre',15)->change();
            $table->string('apellido',15)->change();

            
        });

        Schema::table('instructores', function (Blueprint $table) {

            $table->string('nombre',15)->change();
            $table->string('apellido',15)->change();
            
        });

        Schema::table('visitantes_presenciales', function (Blueprint $table) {

            $table->string('nombre',15)->change();
            $table->string('apellido',15)->change();
            
        });

        Schema::table('proveedores', function (Blueprint $table) {

            $table->string('nombre',15)->change();
            $table->string('apellido',15)->change();
            
        });
    }
}
