<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_amount', function (Blueprint $table) {
            $table->id();
            $table->integer('fees_info_id');
            $table->integer('amount');
            $table->string('date');
           // $table->foreign('fees_info_id')->references('id')->on('fee_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees_amount');
    }
}
