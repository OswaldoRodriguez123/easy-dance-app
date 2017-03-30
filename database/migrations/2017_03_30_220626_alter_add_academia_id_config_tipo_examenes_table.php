<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddAcademiaIdConfigTipoExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_tipo_examenes', function (Blueprint $table) {
            
            $table->integer('academia_id')->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('config_tipo_examenes', function (Blueprint $table) {
            
            $table->dropColumn('academia_id');
            
        });

    }
}
