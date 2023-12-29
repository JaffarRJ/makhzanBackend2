<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('party_id')->unsigned();
            $table->bigInteger('transaction_id')->unsigned();
            $table->boolean('is_active')->default(ACTIVE_RECORD);
            $table->boolean('is_show')->default(HIDE_RECORD);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('party_transactions', function (Blueprint $table) {
            $table->foreign('party_id')->references('id')->on('parties')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('party_transactions');
    }
}
