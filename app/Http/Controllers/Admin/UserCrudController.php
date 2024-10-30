<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;
use App\Models\ThaiProvince;
use App\Models\ThaiAmphure;
use App\Models\ThaiTambon;
use App\Models\User;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
        
    }

    protected function setupListOperation()
    {
        CRUD::column('name_n')->label('First Name');
        CRUD::column('name_s')->label('Last Name');
        CRUD::column('username')->label('Username');
        CRUD::column('email')->label('Email');
        CRUD::column('phone')->label('Phone');
        CRUD::addColumn([
            'name'      => 'role_id',
            'label'     => 'Role',
            'type'      => 'select',
            'entity'    => 'role',  // ความสัมพันธ์กับ Role
            'model'     => 'App\Models\Role',  // Model ของ Role
            'attribute' => 'name',  // แสดงชื่อ role
        ]);
        CRUD::column('province_id')
            ->label('Province')
            ->type('select')
            ->entity('province')
            ->model("App\Models\ThaiProvince")
            ->attribute('name_th');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation([
            'name_n' => 'required',
            'name_s' => 'required',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|min:8',
        ]);
    
        CRUD::field('name_n')->label('First Name')->type('text');
        CRUD::field('name_s')->label('Last Name')->type('text');
        CRUD::field('username')->label('Username')->type('text');
        CRUD::field('email')->label('Email')->type('email');
        CRUD::field('phone')->label('Phone')->type('text');
        CRUD::field('password')->label('Password')->type('password')->hint('Leave empty if not changing');
    
        CRUD::field('gender')->label('Gender')->type('select_from_array')->options([
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
        ]);
    
        CRUD::field('role_id')->label('Role')->type('select')->entity('role')->model("App\Models\Role")->attribute("name");
    
        CRUD::addField([
            'name' => 'province_id',
            'label' => 'Province',
            'type' => 'select_from_array',
            'options' => \App\Models\ThaiProvince::all()->pluck('name_th', 'id')->toArray(),
            'allows_null' => false,
            'wrapper' => ['class' => 'form-group col-md-6'],
            'attributes' => ['id' => 'province-dropdown']
        ]);
    
        CRUD::addField([
            'name' => 'amphure_id',
            'label' => 'Amphure',
            'type' => 'select_from_array',
            'options' => [],
            'allows_null' => false,
            'wrapper' => ['class' => 'form-group col-md-6'],
            'attributes' => ['id' => 'amphure-dropdown']
        ]);
    
        CRUD::addField([
            'name' => 'tambon_id',
            'label' => 'Tambon',
            'type' => 'select_from_array',
            'options' => [],
            'allows_null' => false,
            'wrapper' => ['class' => 'form-group col-md-6'],
            'attributes' => ['id' => 'tambon-dropdown']
        ]);
    
        CRUD::addField([
            'name' => 'zip_code',
            'label' => 'Zip Code',
            'type' => 'text',
            'attributes' => ['readonly' => 'readonly'],
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);
    
        CRUD::addField([
            'name' => 'custom_js',
            'type' => 'custom_html',
            'value' => '<script src="' . asset('js/user-address.js') . '"></script>'
        ]);
    }

    public function setupUpdateOperation()
    {


        $this->setupCreateOperation();
    
        $user = $this->crud->getCurrentEntry();
        $userId = $this->crud->getCurrentEntry()->id;
        CRUD::setValidation([
            'name_n' => 'required',
            'name_s' => 'required',
            'username' => 'required',
            'email' => 'required', // ตรวจสอบอีเมลไม่ซ้ำ ยกเว้น user ปัจจุบัน
            'phone' => 'required',
            'password' => 'nullable|min:8', // ไม่ต้องกรอกรหัสผ่านถ้าไม่เปลี่ยน
        ]);

        // ฟิลด์ password (ไม่แสดงค่า bcrypt ที่บันทึกไว้)
        CRUD::modifyField('password', [
            'type' => 'password',
            'hint' => 'Leave empty if not changing', 
            'value' => '', // ไม่ต้องใส่ค่าเริ่มต้นในฟิลด์ password
        ]);
    
        // ฟิลด์ที่อยู่จะถูกตั้งค่าให้แสดงข้อมูลที่ถูกเลือกก่อนหน้านี้
        CRUD::modifyField('province_id', [
            'type' => 'select_from_array',
            'options' => \App\Models\ThaiProvince::all()->pluck('name_th', 'id')->toArray(),
            'value' => $user->province_id,
            'allows_null' => false,
            'wrapper' => ['class' => 'form-group col-md-6'],
            'attributes' => ['id' => 'province-dropdown']
        ]);
    
        CRUD::modifyField('amphure_id', [
            'type' => 'select_from_array',
            'options' => \App\Models\ThaiAmphure::where('province_id', $user->province_id)->pluck('name_th', 'id')->toArray(),
            'value' => $user->amphure_id,
            'allows_null' => false,
            'wrapper' => ['class' => 'form-group col-md-6'],
            'attributes' => ['id' => 'amphure-dropdown']
        ]);
    
        CRUD::modifyField('tambon_id', [
            'type' => 'select_from_array',
            'options' => \App\Models\ThaiTambon::where('amphure_id', $user->amphure_id)->pluck('name_th', 'id')->toArray(),
            'value' => $user->tambon_id,
            'allows_null' => false,
            'wrapper' => ['class' => 'form-group col-md-6'],
            'attributes' => ['id' => 'tambon-dropdown']
        ]);
    
        CRUD::modifyField('zip_code', [
            'type' => 'text',
            'value' => $user->zip_code,
            'attributes' => ['readonly' => 'readonly'],
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);
    
        // เพิ่ม Save Action และแฮชรหัสผ่านก่อนบันทึก
        $this->crud->addSaveAction([
            'name' => 'save_and_back',
            'redirect' => function ($crud, $request, $entry) use ($user) {
                $entry = $crud->getCurrentEntry(); // Get the current entry as an object
    
                if ($request->filled('password')) {
                    // แฮชรหัสผ่านเฉพาะเมื่อมีการกรอกรหัสใหม่
                    $entry->password = bcrypt($request->input('password'));
                } else {
                    // หากไม่มีการกรอกรหัสผ่านใหม่ ให้ใช้รหัสผ่านเดิมที่มีอยู่จาก $user
                    $entry->password = $user->password;
                }
    
                $entry->save(); // บันทึกการเปลี่ยนแปลง
                return $crud->route; // กลับไปยังหน้า list
            }
        ]);
    }
}
