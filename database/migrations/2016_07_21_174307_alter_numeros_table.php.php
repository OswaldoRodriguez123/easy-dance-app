<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNumerosTable.php extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('instructores', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('visitantes_presenciales', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('proveedores', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('users', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('academias', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('instructores', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('visitantes_presenciales', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('proveedores', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('users', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });

        Schema::table('academias', function ($table) {
            $table->string('telefono')->change();
            $table->string('celular')->change();
        });
    }
}
