<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use CrudTrait;

    protected $fillable = [
        'name',
        'admin_dashboard_access',  // เพิ่มฟิลด์นี้ใน fillable เพื่อให้บันทึกได้
    ];

    // ความสัมพันธ์แบบ many-to-many ระหว่าง Role และ Permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    // ความสัมพันธ์แบบ many-to-many ระหว่าง Role และ User
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}
