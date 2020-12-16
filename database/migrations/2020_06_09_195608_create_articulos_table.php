<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcategoria')->unsigned();
            $table->integer('idubicacion')->unsigned();
            $table->integer('idresponsable')->unsigned();
            $table->string('codigo',50)->nullable();
            $table->string('nombre',100)->unique();
            $table->decimal('costo', 11, 2);
            $table->decimal('vresidual', 11, 2);
            $table->date('fcompra');            
            $table->string('descripcion', 256)->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('condicion')->default(1);

            $table->timestamps();

            $table->foreign('idcategoria')->references('id')->on('categorias');
            $table->foreign('idubicacion')->references('id')->on('ubicaciones');
            $table->foreign('idresponsable')->references('id')->on('responsables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
