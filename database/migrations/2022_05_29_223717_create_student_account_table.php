<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_account', function (Blueprint $table) {
            $table->id();
            $table->string('roll_no');
            $table->integer('fees_id');
            $table->string('fees_type');
            $table->integer('semester');
            $table->string('date');
           // $table->foreign('roll_no')->references('roll_no')->on('student_registration');
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
        Schema::dropIfExists('student_account');
    }
}
