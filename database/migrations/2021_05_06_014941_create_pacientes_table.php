<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Paciente', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idPaciente');
            $table->char('dni', 8)->unique();
            $table->string('nombres', 100);
            $table->string('apellidos', 150);
            $table->string('email', 200)->unique();
            $table->string('telefono', 12);
            $table->string('password');
            $table->string('estado');
            $table->string('foto')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Paciente');
    }
}
