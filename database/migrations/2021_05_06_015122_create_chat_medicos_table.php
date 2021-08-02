<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatMedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ChatMedico', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idChatMedico');
            $table->integer('idPaciente')->unsigned();;
            $table->integer('idMedico')->unsigned();;
            $table->char('estado', 1)->nullable();

           


            $table->foreign('idMedico')
                ->references('idMedico')->on('Medico')
                ;

            $table->foreign('idPaciente')
                ->references('idPaciente')->on('Paciente')
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
        Schema::dropIfExists('ChatMedico');
    }
}
