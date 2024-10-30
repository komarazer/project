<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\EmployeeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class EmployeeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
    }

    protected function setupListOperation()
    {
        // ดึงข้อมูล user จากตาราง users

        CRUD::column('name_n')
            ->label('First Name')
            ->type('select')
            ->entity('user')
            ->model('App\Models\User')
            ->attribute('name_n'); 

        CRUD::column('name_s')
            ->label('Last Name')
            ->type('select')
            ->entity('user')
            ->model('App\Models\User')
            ->attribute('name_s'); 

        CRUD::column('username')
            ->label('Username')
            ->type('select')
            ->entity('user')
            ->model('App\Models\User')
            ->attribute('username'); 

        CRUD::column('province')
            ->label('Province')
            ->type('select')
            ->entity('user.province')
            ->model('App\Models\Province')
            ->attribute('name_th'); 
    
        // ฟิลด์อื่นๆ
        CRUD::column('salary')->label('Salary');
        CRUD::column('hired_date')->label('Hired Date');

        CRUD::column('department')
        ->label('department')
        ->type('select')
        ->entity('department')
        ->model('App\Models\Department')
        ->attribute('name');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeRequest::class);
    
        // ฟิลด์ User
        CRUD::addField([
            'name' => 'user_id',
            'label' => 'User',
            'type' => 'select',
            'entity' => 'user',
            'model' => "App\Models\User",
            'attribute' => 'username',
            'options'   => (function ($query) {
                return $query->whereIn('role_id', [2, 3])->get();
            }),
        ]);
    
        CRUD::field('salary')->label('Salary')->type('number');
        CRUD::field('hired_date')->label('Hired Date')->type('date');

    
        // Dropdown Department
        CRUD::addField([
            'name' => 'department_id',
            'label' => 'Department',
            'type' => 'select',
            'entity' => 'department',
            'model' => "App\Models\Department",
            'attribute' => 'name',
        ]);
    }
    

    protected function setupUpdateOperation()
    {
        CRUD::field('salary')->label('Salary')->type('number');
        CRUD::field('hired_date')->label('Hired Date')->type('date');
        CRUD::field([
            'name' => 'department_id',
            'label' => 'Department',
            'type' => 'select',
            'entity' => 'department',
            'model' => "App\Models\Department",
            'attribute' => 'name',
        ]);
    }

    protected function setupSaveOperation()
    {
        $employee = CRUD::getCurrentEntry();
    }
}
