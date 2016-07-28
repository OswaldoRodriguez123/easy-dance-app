<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_clases_personalizadas', function (Blueprint $table) {
            $table->dropColumn('nombre');
            $table->dropColumn('costo');
            $table->dropColumn('impuesto');
            $table->string('imagen_principal')->after('academia_id');
            $table->string('descripcion',1000)->change();
            $table->string('video_promocional')->after('descripcion');
            $table->string('imagen1')->after('video_promocional');
            $table->string('imagen2')->after('imagen1');
            $table->string('imagen3')->after('imagen2');
            $table->string('ventajas', 1000)->after('imagen3');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_clases_personalizadas', function (Blueprint $table) {
            $table->string('nombre',15)->after('academia_id');
            $table->integer('costo')->after('nombre');
            $table->tinyinteger('impuesto', 4)->after('costo');
            $table->dropColumn('imagen_principal');
            $table->string('descripcion',300)->change();
            $table->dropColumn('video_promocional');
            $table->dropColumn('imagen1');
            $table->dropColumn('imagen2');
            $table->dropColumn('imagen3');
            $table->dropColumn('ventajas');

        });
    }
}
