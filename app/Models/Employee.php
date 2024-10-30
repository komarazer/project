<?php 
namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use CrudTrait;
    protected $fillable = ['user_id', 'salary', 'hired_date', 'department_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
