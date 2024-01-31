<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('loan_id');
            $table->double('debit')->default(0);
            $table->double('credit')->default(0);
            $table->string('transaction_date', 100)->nullable();
            $table->integer('transaction_type');
            $table->string('remarks', 2000)->nullable();;
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
        Schema::dropIfExists('loan_transactions');
    }
}
