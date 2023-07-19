<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fake_users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('id');
            $table->string('localisation1');
            $table->string('localisation2');
            $table->string('mail');
            $table->string('department');
            $table->string('nom_site1');
            $table->string('nom_site2');
            $table->string('sous_direction');
            $table->string('url_photo');
            $table->string('tupreduit');
            $table->string('pole');
            $table->string('salarie_rh');
            $table->string('nom');
            $table->string('prenom');
            $table->string('idns');
            $table->string('url_fiche');
            $table->string('fonction');
            $table->string('direction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fake_users');
    }
}
