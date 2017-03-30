<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddSoftDeleteFormulasExitoValoracionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_formulas_exito', function ($table) {
            $table->softDeletes();
        });

        Schema::table('config_tipo_examenes', function ($table) {
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
        Schema::table('config_formulas_exito', function ($table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('config_tipo_examenes', function ($table) {
            $table->dropColumn('deleted_at');
        });
    }
}
