<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayment_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('loan_id');
            $table->double('amount', 20, 2);
            $table->integer('created_by');
            $table->integer('is_approved')->default(0);
            $table->integer('approved_by')->nullable();
            $table->string('details', 2000)->nullable();
            $table->string('payment_date', 50)->nullable();
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
        Schema::dropIfExists('repayment_logs');
    }
}
