<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
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
        CRUD::setEntityNameStrings('المادة', 'المواد');

        CRUD::addButtonFromView('line', 'toggle_active', 'toggle_active', 'beggining');

        if (!backpack_user()->hasPermissionTo('manage-product')) {
            abort(403, 'غير مخول بالدخول.');
        }
    }

    public function toggleActive($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->activated = !$product->activated;
        $product->save();

        return redirect()->back();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
        CRUD::column([
            'name'      => 'image', // The db column name
            'label'     => 'صورة المنتج', // Table column heading
            'type'      => 'image',
            'prefix' => 'storage/',
            // optional width/height if 25px is not ok with you
            // 'height' => '30px',
            // 'width'  => '30px',
        ]);
        CRUD::modifyColumn('name',['label'=>'الاسم']);
        CRUD::modifyColumn('code', ['label'=>'الرمز']);
        CRUD::modifyColumn('min_quan', ['label'=>'الحد الأدنى']);
        CRUD::column(['name'=>'current_quantity','type'=>'number','label'=>'الكمية الحالية','suffix'=>' قطعة']);
        CRUD::modifyColumn('price', ['label'=>'السعر']);
        CRUD::modifyColumn('activated',['label'=>'مفعّلة','options' => [ 0 => 'غير فعّال', 1 => 'مفعّل' ]]);
        CRUD::removeColumn('group_id');
        CRUD::column(['name'=>'group','type'=>'select','model'=>'App\Models\Group','label'=>'المجموعة','attribute' => 'code']);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        CRUD::modifyField('name',['label'=>'الاسم']);
        CRUD::modifyField('code', ['label'=>'الرمز']);
        CRUD::modifyField('min_quan', ['label'=>'الحد الأدنى']);
        CRUD::modifyField('price', ['label'=>'السعر']);
        CRUD::modifyField('activated',['label'=>'مفعّلة','type'=>'hidden','value'=>true]);
        CRUD::modifyField('group_id',['type'=>'select','model'=>'App\Models\Group','label'=>'المجموعة']);
        CRUD::field([
            'label' => 'Profile Image',
            'name' => 'image',
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'withFiles' => [
                'disk' => 'public', // the disk where file will be stored
                'path' => 'ProductImages',
            ]
        ]);
        
        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
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

    protected function setupDeleteOperation()
    {
        CRUD::field('image')->type('upload')->withFiles();
    }
}
