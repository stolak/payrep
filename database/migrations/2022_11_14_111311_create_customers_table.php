<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('titleID')->nullable();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->string('phone', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('bvn', 50)->nullable();
            $table->string('nin', 50)->nullable();
            $table->integer('marketerID')->nullable();
            $table->longText('address');
            $table->longText('office_address');
            $table->integer('is_h_address_verified')->default(0);
            $table->integer('is_o_address_verified')->default(0);
            $table->integer('registerdBy');
            $table->integer('user_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('status')->default(0);
            $table->longText('guarrantor_full_name')->nullable();
            $table->string('guarrantor_phone', 50)->nullable();
            $table->string('guarrantor_email', 100)->nullable();
            $table->longText('guarrantor_address');
            $table->longText('remarks');
            
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
        Schema::dropIfExists('customers');
    }
}
