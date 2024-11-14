<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Backpack\CRUD\app\Library\Widget;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DashboardController extends Controller
{
    public function index()
    {
        Widget::add([
            'type'    => 'div',
            'class'   => 'row',
            'content' => [ // widgets
                [
                    'type' => 'view',
                    'view' => 'vendor.backpack.ui.widgets.list_with_imports_and_exports',
                ],
                [
                    'type'       => 'chart',
                    'controller' => \App\Http\Controllers\Admin\Charts\ProductCurrentQuantityChartController::class,
                ],
                [
                    'type' => 'view',
                    'view' => 'vendor.backpack.ui.widgets.list_with_top_10',
                ],
            ]
        ])->to('before_content');

        Widget::add([
            'type'    => 'div',
            'class'   => 'row',
            'content' => [ // widgets
                [
                    'type' => 'view',
                    'view' => 'vendor.backpack.ui.widgets.list_last_month',
                ],
                [
                    'type' => 'view',
                    'view' => 'vendor.backpack.ui.widgets.list_out_of_stock',
                ],
                [
                    'type' => 'view',
                    'view' => 'vendor.backpack.ui.widgets.list_inactive',
                ],
            ]
        ])->to('before_content');

        return view('admin.dashboard', [
            'title' => 'لوحة التحكم',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'لوحة التحكم' => false,
            ],
            'page' => 'resources/views/admin/dashboard.blade.php',
            'controller' => 'app/Http/Controllers/Admin/DashboardController.php',
        ]);
    }
}
