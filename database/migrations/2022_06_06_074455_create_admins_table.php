<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username');
            $table->string('admin_id')->unique();
            $table->string('email')->unique();
            $table->string('national_id')->unique();
            $table->string('phone')->nullable();
            $table->string('mobile')->unique();
            $table->string('address');
            $table->tinyInteger('status')->default(0);
            $table->string('password');
            $table->bigInteger('role');	    
            $table->string('refered_by')->default(1);
            $table->date('expiry_date');
            $table->string('area_id')->nullable();
            $table->unsignedBigInteger('city_id')->default(1);
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('admins');
    }
}
