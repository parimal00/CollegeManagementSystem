<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOthersAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('others_account', function (Blueprint $table) {
            $table->id();
            $table->string('roll_no');
            $table->integer('semester');
            $table->string('fee_info');
            $table->integer('amount');
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
        Schema::dropIfExists('others_account');
    }
}
