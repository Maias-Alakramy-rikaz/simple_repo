<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImportRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ImportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ImportCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Import::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/import');
        CRUD::setEntityNameStrings('وارد', 'واردات');

        if (!backpack_user()->hasPermissionTo('manage-import')) {
            abort(403, 'غير مخول بالدخول.');
        }
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
        CRUD::removeColumn('product_id');
        CRUD::column(['name'=>'Product','label'=>'المادة']);
        CRUD::modifyColumn('quantity', ['label'=>'الكمية','suffix'=>' قطعة']);
        CRUD::modifyColumn('imp_date', ['label'=>'التاريخ']);
        CRUD::removeColumn('importer_id');
        CRUD::column(['name'=>'Importer','label'=>'المورد','attribute'=>'full_name']);

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
        CRUD::setValidation(ImportRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        CRUD::setFromDb(); // set fields from db columns.
        CRUD::modifyField('product_id',['type'=>'select','model'=>'App\Models\Product','label'=>'المادة']);
        CRUD::modifyField('quantity', ['label'=>'الكمية','suffix'=>' قطعة']);
        CRUD::modifyField('imp_date', ['label'=>'التاريخ']);
        CRUD::modifyField('importer_id',['type'=>'select','model'=>'App\Models\Importer','label'=>'المورد','attribute'=>'full_name']);
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

    public function store(ImportRequest $request)
    {
        if (!backpack_user()->hasPermissionTo('manage-import')) {
            abort(403, 'غير مخول بالدخول.');
        }
            
        \DB::beginTransaction();
        try {
            $product = \App\Models\Product::find($request->input('product_id'));
            $product->updateCurrentQuantity(false,$request->input('quantity'));
            $response = $this->traitStore();
            \DB::commit();
            return $response;
        } catch (\Throwable $th) {
            \DB::rollback();
            \Alert::error('حدث خطأ')->flash();
        }
        return redirect()->back();
    }
}
