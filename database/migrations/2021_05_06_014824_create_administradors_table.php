<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Administrador', function (Blueprint $table) {
            
            $table->increments('idAdministrador');
           
            $table->string('nombres', 100)->nullable();
            $table->string('apellidos', 150)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('password', 250)->nullable();
            $table->string('area', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Administrador');
    }
}
