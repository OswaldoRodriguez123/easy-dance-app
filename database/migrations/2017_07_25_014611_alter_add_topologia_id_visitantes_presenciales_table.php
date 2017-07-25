<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTopologiaIdVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->integer('tipologia_id')->unsigned()->nullable()->default(null);
            $table->foreign('tipologia_id')->references('id')->on('tipologias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->dropForeign('visitantes_presenciales_tipologia_id_foreign');
            $table->dropColumn('tipologia_id');
        });
    }
}
