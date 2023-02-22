<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('user_id')->unique();
            $table->string('email')->unique();
            $table->string('national_id')->unique();
            $table->string('phone')->nullable();
            $table->string('mobile')->unique();
            $table->string('address');
            $table->tinyInteger('status')->default(2);  
            $table->string('refered_by')->default(1);
            $table->string('package_name');
            $table->string('package_price');
            $table->date('payment_date');
            $table->unsignedBigInteger('city_id')->default(1);
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedBigInteger('area_id')->default(1);
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
