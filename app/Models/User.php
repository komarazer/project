<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use CrudTrait;
    use HasFactory, Notifiable;

    protected $fillable = [
        'name_n',
        'name_s',
        'username',
        'email',
        'phone',
        'gender',
        'password',
        'role_id',
        'province_id',
        'amphure_id',
        'tambon_id',
        'zip_code',
        'address_detail'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ความสัมพันธ์ระหว่าง User และ Role (ผู้ใช้มีบทบาทเดียว)
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // ความสัมพันธ์กับ Employee
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    // ความสัมพันธ์กับที่อยู่
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function province()
    {
        return $this->belongsTo(ThaiProvince::class, 'province_id');
    }

    public function amphure()
    {
        return $this->belongsTo(ThaiAmphure::class, 'amphure_id');
    }

    public function tambon()
    {
        return $this->belongsTo(ThaiTambon::class, 'tambon_id');
    }
}
