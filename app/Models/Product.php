<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category_id', 'image'];



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */    
    // ฟังก์ชันสำหรับจัดการการอัปโหลดและการลบรูปภาพ
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "public"; // กำหนด disk ที่ใช้เก็บไฟล์
        $destination_path = "uploads/products"; // โฟลเดอร์ที่เก็บไฟล์

        // ตรวจสอบและลบไฟล์เก่าถ้ามี
        if ($this->{$attribute_name}) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
        }

        // อัปโหลดไฟล์ใหม่ถ้ามีการอัปโหลด
        if (request()->hasFile($attribute_name)) {
            $this->attributes[$attribute_name] = request()->file($attribute_name)->store($destination_path, $disk);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
