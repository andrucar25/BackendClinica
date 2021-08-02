<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Medico', function (Blueprint $table) {
            $table->increments('idMedico');
            $table->string('nombres', 100);
            $table->string('apellidos', 150);
            $table->string('email', 200)->unique();
            $table->string('password');
            $table->string('cv');
            $table->string('foto')->nullable();
            $table->string('estado');
            $table->integer('idEspecialidad')->unsigned();
            $table->foreign('idEspecialidad')
                ->references('idEspecialidad')->on('Especialidad')
             ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Medico');
    }
}
