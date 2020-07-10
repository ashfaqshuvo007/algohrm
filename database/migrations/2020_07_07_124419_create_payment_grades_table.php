<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grade');
            $table->bigInteger('created_by');
            $table->string('basic_salary');
            $table->string('yearly_increment_rate');
            $table->string('house_rent');
            $table->string('medical_allowance');
            $table->string('travel_allowance');
            $table->string('food_allowance');
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
        Schema::dropIfExists('payment_grades');
    }
}
