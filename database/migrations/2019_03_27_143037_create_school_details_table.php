<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->string('currency')->nullable();
            $table->string('running_session')->nullable();
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
        Schema::dropIfExists('school_details');
    }
}
