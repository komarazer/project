<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RunSqlFile extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ระบุพาธไฟล์ .sql ที่ต้องการรัน
        $sqlFilePath = database_path('migrations\dormitorymaintenance_db.sql'); 

        // อ่านไฟล์ SQL
        $sql = File::get($sqlFilePath);

        // รันคำสั่ง SQL ดิบ
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ระบุคำสั่ง SQL ที่จะใช้ลบหรือ rollback
    }
}