<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddDeletedAtUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('users', function (Blueprint $table) {
            $table->integer('deleted_at_usuario_id');
            $table->date('deleted_at_fecha');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at_usuario_id');
            $table->dropColumn('deleted_at_fecha');
        });
    }
}
