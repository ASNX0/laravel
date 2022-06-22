<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'todos',
            function (Blueprint $table) {
            $table->id();
            $table->integer('bus_id');
            $table->string('name');
            $table->string('email');
            $table->string('trip_name');
            $table->timestamps();
            }
        );

    }//end up()


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');

    }//end down()


}//end class
