<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Laboratorio', function (Blueprint $table) {
            $table->increments('idLaboratorio');
            $table->integer('idPaciente')->unsigned();
            $table->text('descripcion')->nullable();
            $table->date('fecha')->nullable();
            $table->string('responsable', 100)->nullable();
            $table->string('area', 100)->nullable();
            $table->string('archivo')->nullable();

            $table->foreign('idPaciente')
                ->references('idPaciente')->on('Paciente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Laboratorio');
    }
}
