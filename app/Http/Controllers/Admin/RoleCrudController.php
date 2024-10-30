<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class RoleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Role::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/role');
        CRUD::setEntityNameStrings('role', 'roles');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @return void
     */
    protected function setupListOperation()
    {
        // แสดงทั้ง id และ name ในตาราง
        CRUD::column('id')->label('ID');
        CRUD::column('name')->label('Role Name');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RoleRequest::class);
    
        // ฟิลด์ name สามารถแก้ไขได้
        CRUD::field('name')->label('Role Name');
    
        // เพิ่มฟิลด์ admin-dashboard เพื่อควบคุมสิทธิ์การเข้าถึงหน้า admin-dashboard
        CRUD::addField([
            'name'      => 'admin_dashboard_access', // ชื่อฟิลด์ในฐานข้อมูล
            'label'     => 'Admin Dashboard Access', // ป้ายชื่อฟิลด์ที่แสดงในฟอร์ม
            'type'      => 'select_from_array',      // ใช้ select_from_array เพื่อสร้าง dropdown
            'options'   => [0 => 'No Access', 1 => 'Access'], // ตัวเลือก 0 และ 1
            'allows_null' => false,  // บังคับให้ต้องเลือกค่า
            'default'   => 0,        // ค่าเริ่มต้นคือ 0 (No Access)
            'wrapper' => [
                'class' => 'form-group col-md-6',   // จัดรูปแบบฟอร์ม
            ],
        ]);
    }
    

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation(); // เรียกใช้การตั้งค่าของ create operation
    }
}
