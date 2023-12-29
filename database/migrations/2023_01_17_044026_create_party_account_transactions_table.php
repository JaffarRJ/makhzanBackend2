<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartyAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_account_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('party_id')->unsigned();
            $table->bigInteger('transaction_id')->unsigned();
            $table->bigInteger('account_id')->unsigned();
            $table->bigInteger('sub_account_id')->unsigned();
            $table->tinyInteger('amount')->default(0);
            $table->integer('transaction_type')->default(0)->unsigned();
            $table->boolean('is_active')->default(ACTIVE_RECORD);
            $table->boolean('is_show')->default(HIDE_RECORD);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('party_account_transactions', function (Blueprint $table) {
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('party_account_transactions');
    }
}
