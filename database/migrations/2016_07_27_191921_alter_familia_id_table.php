<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFamiliaIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->dropForeign('users_familia_id_foreign');
            $table->dropColumn('familia_id');
            
        });

        Schema::table('alumnos', function (Blueprint $table) {
            
            $table->integer('familia_id')->after('academia_id')->unsigned()->nullable()->default(null);
            $table->foreign('familia_id')->references('id')->on('familias');
            
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
            
            $table->dropForeign('alumnos_familia_id_foreign');
            $table->dropColumn('familia_id');
            
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('familia_id')->after('academia_id')->unsigned()->nullable()->default(null);
            $table->foreign('familia_id')->references('id')->on('familias');
        });
    }
}
