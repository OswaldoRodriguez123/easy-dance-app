<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddFieldsMercadopagoMovsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mercadopago_movs', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            $table->integer('alumno_id')->unsigned()->nullable()->change();
            $table->integer('user_id')->after('alumno_id')->nullable();
            $table->integer('externo_id')->after('user_id')->nullable();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mercadopago_movs', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            DB::statement('ALTER TABLE `mercadopago_movs` MODIFY `alumno_id` INTEGER UNSIGNED NOT NULL;');

            $table->dropColumn('user_id');
            $table->dropColumn('externo_id');

            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        });
    }
}
