<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToSocialAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_accounts', function (Blueprint $table){
            $table->string('name');
            $table->string('email')->unique();
            $table->string('facebook_id')->unique();
            $table->string('avatar');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_accounts', function (Blueprint $table){
            $table->dropColumn('name');
            $table->dropColumndropColumn('email')->unique();
            $table->dropColumn('facebook_id')->unique();
            $table->dropColumn('avatar');
            $table->rememberToken();
        });
    }
}
