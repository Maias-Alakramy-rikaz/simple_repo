<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImporterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Gate;

/**
 * Class ImporterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ImporterCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Importer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/importer');
        CRUD::setEntityNameStrings('مورد', 'موردون');

        CRUD::addButtonFromView('line', 'toggle_block', 'toggle_block', 'beggining');

        if (!backpack_user()->hasPermissionTo('manage-importer')) {
            abort(403, 'غير مخول بالدخول.');
        }
    }

    public function toggleBlock($id)
    {
        if (!Gate::allows('block')) {
            \Alert::error('لا يمكنك القيام بذلك')->flash();
            return redirect()->back();
        }
        $importer = $this->crud->model->findOrFail($id);
        $importer->blocked = !$importer->blocked;
        $importer->save();
        \Alert::success('تم التغيير بنجاح')->flash();
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
        // CRUD::setFromDb(); // set columns from db columns.
        CRUD::column(['name'=> 'full_name', 'label'=>'الاسم الكامل']);
        CRUD::column(['name'=> 'phone_number', 'label'=>'رقم الهاتف']);
        CRUD::column(['name'=> 'email', 'label'=>'البريد الإلكتروني']);
        CRUD::column(['name'=> 'blocked','type'=>'boolean','label'=>'التعامل','options' => [ 0 => 'مسموح', 1 => 'ممنوع' ]]);

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
        CRUD::setValidation(ImporterRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        CRUD::modifyField('first_name', ['label'=>'الاسم']);
        CRUD::modifyField('last_name', ['label'=>'الكنية']);
        CRUD::modifyField('phone_number', ['label'=>'رقم الهانف']); 
        CRUD::modifyField('email', ['label'=>'الإيميل']); 
        CRUD::modifyField('bloked',['label'=>'منع التعامل','type'=>'hidden','value'=>false]);

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
}
