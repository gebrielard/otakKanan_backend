<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->integer('room_id')->unsigned()->change();
            $table->foreign('room_id')->references('room_id')->on('rooms')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('room_functions', function (Blueprint $table) {
            $table->integer('room_id')->unsigned()->change();
            $table->foreign('room_id')->references('room_id')->on('rooms')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->integer('room_id')->unsigned()->change();
            $table->foreign('room_id')->references('room_id')->on('rooms')
                ->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relation');
    }
}
