<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('contact_person', 255);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->text('address');
            
            // สร้างคอลัมน์ serial_id ที่จะเป็น foreign key
            $table->unsignedBigInteger('serial_id'); // คอลัมน์ serial_id ต้องเป็น unsignedBigInteger
        
            // สร้าง foreign key constraint โดยเชื่อม serial_id กับ id ของตาราง serials
            $table->foreign('serial_id')->references('id')->on('serials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
