<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    use CrudTrait;
    use CrudTrait;
    use HasFactory;

    protected $table = 'serials';
    protected $guarded = ['id'];
    protected $fillable = ['serial', 'status'];
}
