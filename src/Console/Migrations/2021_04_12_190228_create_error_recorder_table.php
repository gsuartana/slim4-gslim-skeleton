<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorRecorderTable extends Migration
{
    public function up()
    {
        Schema::create('error_recorder', function (Blueprint $table) {
            $table->increments('id');
            $table->string("type")->nullable();
            $table->text("message")->nullable();
            $table->text("source")->nullable();
            $table->text("userAgent")->nullable();
            $table->text("location")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('error_recorder' );
    }
}
