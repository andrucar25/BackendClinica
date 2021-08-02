<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmaciaPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FarmaciaPedido', function (Blueprint $table) {
            $table->increments('idFarmaciaPedido');
            $table->integer('idTeleconsulta')->unsigned();;
            $table->char('estado', 1);
            $table->char('metodoPago', 1);
            $table->string('descripcion')->nullable();
            $table->string('direccion');
            $table->foreign('idTeleconsulta')
                ->references('idTeleconsulta')->on('Teleconsulta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FarmaciaPedido');
    }
}
