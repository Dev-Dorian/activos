<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreResponsable',50);
            $table->string('num_documento', 20)->nullable();
            $table->string('telefonoResponsable', 20)->nullable();
            $table->string('descripcionResponsable',256)->nullable();
            $table->boolean('condicion')->default(1);
            //$table->string('codigo', 20)->nullable();
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
        Schema::dropIfExists('responsables');
    }
}
