<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('origin_wallet_id');
            $table->unsignedBigInteger('target_wallet_id');
            $table->uuid('hash');
            $table->double('value');

            $table->foreign('origin_wallet_id')
                ->references('id')
                ->on('tb_wallet');
            
            $table->foreign('target_wallet_id')
                ->references('id')
                ->on('tb_wallet');

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
        Schema::dropIfExists('tb_transaction');
    }
}
