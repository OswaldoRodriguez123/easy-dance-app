<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInstructoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('instructores', function (Blueprint $table) {
            $table->string('facebook')->after('estatus');
            $table->string('twitter')->after('facebook');
            $table->string('linkedin')->after('twitter');
            $table->string('instagram')->after('linkedin');
            $table->string('pagina_web')->after('instagram');
            $table->string('youtube')->after('pagina_web');
            $table->string('imagen_artistica')->after('youtube');
            $table->string('descripcion', 1000)->after('imagen_artistica');
            $table->string('video_promocional')->after('descripcion');
            $table->string('resumen_artistico', 1000)->after('video_promocional');
            $table->string('video_testimonial')->after('resumen_artistico');
            $table->boolean('boolean_promocionar')->after('video_testimonial')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instructores', function (Blueprint $table) {
            $table->dropColumn('facebook');
            $table->dropColumn('twitter');
            $table->dropColumn('linkedin');
            $table->dropColumn('instagram');
            $table->dropColumn('pagina_web');
            $table->dropColumn('youtube');
            $table->dropColumn('imagen_artistica');
            $table->dropColumn('descripcion');
            $table->dropColumn('video_promocional');
            $table->dropColumn('resumen_artistico');
            $table->dropColumn('video_testimonial');
            $table->dropColumn('boolean_promocionar');
        });
    }
}
