<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeleconsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Teleconsulta', function (Blueprint $table) {
            $table->increments('idTeleconsulta');
            $table->integer('idPaciente')->unsigned();;
            $table->integer('idMedico')->unsigned();;
            $table->text('diagnostico')->nullable();
            $table->string('receta')->nullable();
            $table->char('estadoConsulta', 1);
            $table->char('estadoPago', 1);
            $table->dateTime('fechaHora');
            $table->string('enlace', 250)->nullable();

          


            $table->foreign('idPaciente')
                ->references('idPaciente')->on('Paciente')
              ;

            $table->foreign('idMedico')
                ->references('idMedico')->on('Medico')
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
        Schema::dropIfExists('Teleconsulta');
    }
}
