<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('loans');
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('loan_type_id');
            $table->double('amount', 20, 2)->default(0);
            $table->double('amount_marketer', 20, 2)->default(0);
            $table->double('amount_accountant', 20, 2)->default(0);
            $table->double('amount_approved', 20, 2)->default(0);
            $table->integer('marketer_id')->nullable();
            $table->integer('accountant_id')->nullable();
            $table->integer('approver_id')->nullable();
            $table->integer('period');
            $table->double('percentage', 11, 2);
            $table->string('approval_date', 100)->nullable();
            $table->string('disbursed_date', 100)->nullable();
            $table->double('total_interest', 20, 2)->default(0);
            $table->double('monthly_repayment', 20, 2)->default(0);
            $table->double('total_repayment', 20, 2)->default(0);
            $table->double('amount_outstanding', 20, 2)->default(0);
            $table->string('next_due_date', 100)->nullable();
            $table->string('remarks', 1000)->nullable();
            $table->integer('stage')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('loans');
    }
}
