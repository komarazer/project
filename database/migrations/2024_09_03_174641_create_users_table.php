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
            $table->id(); // กำหนด id เป็น auto-increment primary key
            $table->string('name_n');
            $table->string('name_s');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->foreignId('role_id')->constrained('roles')->default(1);
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('amphure_id')->nullable();
            $table->unsignedBigInteger('tambon_id')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address_detail')->nullable();
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
        Schema::dropIfExists('users'); // ลบตาราง users เมื่อ rollback
    }
}