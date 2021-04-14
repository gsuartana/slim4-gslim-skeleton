<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTokenTable extends Migration
{
    public function up()
    {
        Schema::create('master_token', function (Blueprint $table) {
            $table->increments('id');
            $table->string("hash_key")->nullable();
            $table->timestamp("expire_date_time")->nullable();
            $table->integer("expire_unix_time")->nullable();
            $table->string("status")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_token' );
    }
}
