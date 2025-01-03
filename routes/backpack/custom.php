<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('export', 'ExportCrudController');
    Route::crud('exporter', 'ExporterCrudController');
    Route::crud('group', 'GroupCrudController');
    Route::crud('import', 'ImportCrudController');
    Route::crud('importer', 'ImporterCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('product-image', 'ProductImageCrudController');
    Route::crud('user', 'UserCrudController');
    Route::get('product/{id}/toggle-active', 'App\Http\Controllers\Admin\ProductCrudController@toggleActive');
    Route::get('exporter/{id}/toggle-block', 'App\Http\Controllers\Admin\ExporterCrudController@toggleBlock');
    Route::get('importer/{id}/toggle-block', 'App\Http\Controllers\Admin\ImporterCrudController@toggleBlock');
    Route::get('charts/product-current-quantity', 'Charts\ProductCurrentQuantityChartController@response')->name('charts.product-current-quantity.index');
    Route::get('dashboard', 'DashboardController@index')->name('page.dashboard.index');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
