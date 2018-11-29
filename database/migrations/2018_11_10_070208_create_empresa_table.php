<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nombre_empresa');
            $table->string('nit_empresa');
            $table->string('direccion_empresa');
            $table->string('telefono_oficina');
            $table->string('telefono_empresa');
            $table->string('correo_empresa');
            $table->string('telefono_encargado');
            $table->string('correo_encargado');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
