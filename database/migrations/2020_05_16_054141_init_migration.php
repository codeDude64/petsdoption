<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',32);
            $table->string('apellido_paterno',32);
            $table->string('apellido_materno',32);
            $table->string('email',32)->unique();
            $table->string('password');
            $table->string('celular',10);
            $table->string('imagen',100)->nullable();
            $table->date('fecha_nacimiento');
            $table->string('estado');
            $table->string('ciudad');
        });

        Schema::create('rescatistas', function (Blueprint $table) {
           $table->id();
           $table->string('descripcion', 100)->nullable();
           $table->foreignId('usuario_id');
           $table->foreign('usuario_id')->references('id')->on('usuarios');
        });

        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 32);
            $table->string('imagen', 100);
            $table->string('tipo', 32);
            $table->string('descripcion', 100)->nullable();
        });

        Schema::create('rescates', function (Blueprint $table) {
           $table->id();
           $table->string('descripcion', 100);
           $table->date('fecha');
           $table->date('fecha_limite');
           $table->foreignId('rescatista_id')->nullable();
           $table->foreign('rescatista_id')->references('id')->on('rescatistas');
           $table->foreignId('mascota_id')->nullable();
           $table->foreign('mascota_id')->references('id')->on('mascotas');
        });

        Schema::create('organizaciones', function (Blueprint $table) {
           $table->id();
           $table->string('nombre');
           $table->string('estado');
           $table->string('ciudad');
           $table->string('calle');
           $table->string('colonia');
           $table->integer('numero');
           $table->integer('telefono');
        });

        Schema::create('candidato', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100)->nullable();
            $table->foreignId('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });

        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('candidato_id');
            $table->foreign('candidato_id')->references('id')->on('candidato');
        });

        Schema::create('adopciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('solicitudes');
        });

        //TODO: investigar sobre vacunas y actitudes

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('adopciones');
        Schema::drop('solicitudes');
        Schema::drop('candidato');
        Schema::drop('organizaciones');
        Schema::drop('rescates');
        Schema::drop('mascotas');
        Schema::drop('rescatistas');
        Schema::drop('usuarios');
    }
}
