<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->bigInteger('invoice_id')->nullable()->default(0);
            $table->unsignedBigInteger('receivable_id')->default(1);
            $table->foreign('receivable_id')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('payable_id')->default(1);
            $table->foreign('payable_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('admin_id');
            $table->bigInteger('payment')->default(0);
            $table->bigInteger('otc')->nullable();
            $table->bigInteger('advance_payment')->nullable();
            $table->bigInteger('pending_payment')->nullable();
            $table->string('month');
            $table->date('next_recovery_date');
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
        Schema::dropIfExists('ledgers');
    }
}
