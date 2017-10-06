<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropForeignInstructorIdExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('examenes', function (Blueprint $table) {
            $table->dropForeign('examenes_instructor_id_foreign');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('examenes', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructores');
        });
    }
}

