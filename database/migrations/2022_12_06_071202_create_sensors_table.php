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
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('organization_id');
            $table->uuid('uuid');
            $table->string('mqtt_topic');
            $table->string('mqtt_ip');
            $table->string('mqtt_port');
            $table->string('network_interface');
            $table->string('protected_subnet');
            $table->string('external_subnet');
            $table->foreign('organization_id')->references('id')->on('organizations') ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sensors');
    }
};
