<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles',function (Blueprint $table){
            $table->increments('id');
            $table->string('nombre',30);
            $table->string('descripcion',100)->nullable();
            $table->boolean('condicion')->default(1);
        });
        DB::table('roles')->insert(array(
            'id'=>'1',
            'nombre'=>'Administrador',
            'descripcion'=>'Administradores de area'));

        DB::table('roles')->insert(array(
            'id'=>'2',
            'nombre'=>'Usuario',
            'descripcion'=>'Usuario de area'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
