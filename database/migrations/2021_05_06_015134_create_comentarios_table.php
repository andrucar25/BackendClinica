<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Comentario', function (Blueprint $table) {
          
            $table->increments('idComentario');
            $table->integer('idMedico')->unsigned();;
            $table->integer('idPaciente')->unsigned();;
            $table->integer('puntuacion')->unsigned();;
            $table->char('estado', 1)->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fecha')->nullable();

    

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
        Schema::dropIfExists('Comentario');
    }
}
