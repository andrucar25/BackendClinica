<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioMedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HorarioMedico', function (Blueprint $table) {
            $table->increments('idHorarioMedico');
            $table->integer('idMedico')->unsigned();;
            $table->string('dia')->nullable();
            $table->string('horaInicio')->nullable();
            $table->string('horaFin')->nullable();

        


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
        Schema::dropIfExists('HorarioMedico');
    }
}
