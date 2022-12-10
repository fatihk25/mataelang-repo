<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_heartbeat', function (Blueprint $table) {
            $table->id();
            $table->integer('sensor_id');
            $table->foreign('sensor_id')->references('id')->on('sensors') ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('last_seen')->nullable();
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
        Schema::dropIfExists('sensor_heartbeat');
    }
};
