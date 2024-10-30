<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name', 255); // ชื่อสินค้า
            $table->text('description')->nullable(); // คำอธิบายสินค้า
            $table->decimal('price', 8, 2); // ราคา (precision 8, scale 2)
            $table->integer('stock')->default(0); // สต็อกสินค้า
            $table->unsignedBigInteger('category_id'); // FK to categories.id
            $table->timestamps(); // created_at, updated_at
    
            // กำหนด Foreign Key (เชื่อมกับตาราง categories)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
