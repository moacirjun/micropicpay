<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnOnUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_user', function(Blueprint $table) {
            $newColumn = $table->tinyInteger('type');
            $newColumn->default(1);
            $newColumn->nullable(false);
            $newColumn->after('age');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_user', function(Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
