<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PregReplace extends Migration
{
    public function up()
    {
        Schema::create('Tablename', function (Blueprint $table) {
            $table->increments('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Tablename' );
    }
}
