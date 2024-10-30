<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ใช้ unsignedBigInteger สำหรับเชื่อมโยงกับ users.id
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('hired_date')->nullable();
            $table->unsignedBigInteger('department_id')->nullable(); // department_id เชื่อมกับตาราง departments
            $table->timestamps();
        
            // กำหนด Foreign Key สำหรับ user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
