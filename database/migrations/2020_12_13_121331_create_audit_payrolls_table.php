<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by');
            $table->integer('user_id');
            $table->tinyInteger('employee_type')->comment('1 for Provision & 2 for Permanent');
            $table->string('basic_salary')->nullable();
            $table->string('house_rent')->nullable();
            $table->string('medical_allowance')->nullable();
            $table->string('food_allowance')->nullable();
            $table->string('convaoyance')->nullable();
            $table->string('overtime_rate')->nullable();
            $table->string('absent_deduction')->nullable();
            $table->string('att_bonus')->nullable();
            $table->string('increment_amount')->nullable();
            $table->tinyInteger('activation_status')->default(0);
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
        Schema::dropIfExists('audit_payrolls');
    }
}