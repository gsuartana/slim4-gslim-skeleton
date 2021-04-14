<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PregReplace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tablename', function (Blueprint $table) {
            // Drop it
            //$table->dropForeign(['server_id']);

            // Rename
            //$table->renameColumn('server_id', 'linux_server_id');

            // Add it
            //$table->foreign('linux_server_id')->references('id')->on('linux_servers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tablename', function (Blueprint $table) {
            // Drop it
            //$table->dropForeign(['linux_server_id']);

            // Rename
            //$table->renameColumn('linux_server_id', 'server_id');

            // Add it
            //$table->foreign('server_id')->references('id')->on('linux_servers');
        });
    }
}
