<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExportRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ExportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ExportCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Export::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/export');
        CRUD::setEntityNameStrings('صادر', 'صادرات');

        if (!backpack_user()->hasPermissionTo('manage-export')) {
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
        CRUD::modifyColumn('exp_date', ['label'=>'التاريخ']);
        CRUD::removeColumn('exporter_id');
        CRUD::column(['name'=>'Exporter','label'=>'الزبون','attribute'=>'full_name']);


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
        CRUD::setValidation(ExportRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        CRUD::modifyField('product_id',['type'=>'select','model'=>'App\Models\Product','label'=>'المادة']);
        CRUD::modifyField('quantity', ['label'=>'الكمية','suffix'=>' قطعة']);
        CRUD::modifyField('exp_date',[   // DateTime
            'type'  => 'date_picker',
            'label' => 'التاريخ',
         
            // optional:
            'datetime_picker_options' => [
               'todayBtn' => 'linked',
               'format'   => 'dd-mm-yyyy',
               'language' => 'ar'
            ],
        ]);
            CRUD::modifyField('exporter_id',['type'=>'select','model'=>'App\Models\Exporter','label'=>'الزبون','attribute'=>'full_name']);   
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


    public function store(ExportRequest $request)
    {
        if (!backpack_user()->hasPermissionTo('manage-export')) {
            abort(403, 'غير مخول بالدخول.');
        }
            
        \DB::beginTransaction();
        try {
            $product = \App\Models\Product::find($request->input('product_id'));
            $product->updateCurrentQuantity(true,$request->input('quantity'));
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
