<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use CrudTrait;
    protected $fillable = ['name'];

    // ความสัมพันธ์กับ Role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
