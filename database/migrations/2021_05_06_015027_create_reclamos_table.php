<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReclamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Reclamo', function (Blueprint $table) {
            $table->increments('idReclamo');
            $table->char('tipo', 1);
            $table->text('descripcion');
            $table->integer('idPaciente')->unsigned();;
            $table->date('fecha');
            $table->char('estado', 1);
            $table->string('archivo')->nullable();

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
        Schema::dropIfExists('Reclamo');
    }
}
