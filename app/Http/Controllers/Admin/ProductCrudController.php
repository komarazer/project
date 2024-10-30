<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('name')->label('Product Name');
        CRUD::column('price')->label('Price');
        CRUD::addColumn([
            'name' => 'category_id', // ฟิลด์ category_id ในตาราง products
            'label' => 'Category/',   // ชื่อที่จะแสดงในตาราง
            'type' => 'select',      // ใช้ type select
            'entity' => 'category',  // ความสัมพันธ์กับ model Category
            'model' => "App\\Models\\Category", // ระบุ Model ของ Category
            'attribute' => 'name',   // ระบุให้แสดงชื่อ (name) ของ Category
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setFromDb(); // set fields from db columns.
        CRUD::setValidation(ProductRequest::class);

        CRUD::field('name')->label('Product Name');
        CRUD::field('description')->label('Description');
        CRUD::field('price')->label('Price');

        CRUD::addField([
            'name' => 'category_id', // ฟิลด์ category_id ในตาราง products
            'label' => 'Category', // ป้ายกำกับ
            'type' => 'select', // ใช้ฟิลด์ select
            'entity' => 'category', // ความสัมพันธ์กับ model Category
            'model' => "App\\Models\\Category", // Model ของ Category
            'attribute' => 'name', // ฟิลด์ที่จะแสดงใน dropdown (name)
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }), // กำหนด option ให้เรียงตามชื่อ
        ]);

        CRUD::addField([
            'name' => 'image',
            'label' => 'Product Image',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

        // ฟังก์ชันลบสินค้าและรูปภาพ
        public function destroy($id)
        {
            // ตรวจสอบและลบไฟล์รูปภาพก่อนลบสินค้า
            $product = Product::find($id);
            if ($product && $product->image) {
                \Storage::disk('public')->delete($product->image);
            }
    
            // เรียกใช้ฟังก์ชันลบของ Backpack
            return parent::destroy($id);
        }
}
