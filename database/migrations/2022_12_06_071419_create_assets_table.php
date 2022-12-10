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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('organization_id')->nullable();
            $table->integer('pic_id')->nullable();
            $table->integer('sensor_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('organizations') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sensor_id')->references('id')->on('sensors') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pic_id')->references('id')->on('users') ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('assets');
    }
};
