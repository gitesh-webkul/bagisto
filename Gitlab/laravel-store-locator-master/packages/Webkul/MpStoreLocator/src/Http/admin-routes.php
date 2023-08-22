<?php


Route::group([
        'prefix'        => 'admin/mpstorelocator',
        'middleware'    => ['web', 'admin']
    ], function () {

        /*Start: Manage Stores routes Start*/

        Route::get('/get-state', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@getState')->name('admin.mpstorelocator.get-state');

        Route::get('/admin/shipping-method', 'Webkul\MpStoreLocator\Http\Controllers\Admin\SettingController@shippingMethods')
        ->defaults('_config', [
            'view' => 'mpstorelocator::admin.setting.shipping-method',
        ])
        ->name('admin.mpstorelocator.admin.shipping-methods');

        Route::get('/', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@index')->defaults('_config', [
            'view' => 'mpstorelocator::admin.index',
        ])->name('admin.mpstorelocator.index');

        Route::get('/stores', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@index')->defaults('_config', [
            'view' => 'mpstorelocator::admin.stores.list',
        ])->name('admin.mpstorelocator.stores');


        Route::get('/stores/create', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@create')->defaults('_config', [
            'view' => 'mpstorelocator::admin.stores.create',
        ])->name('admin.mpstorelocator.stores.create');
        
        Route::post('/stores/mass-delete', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@massDelete')
       
        ->name('admin.mpstorelocator.stores.massdelete');

        Route::get('/stores/edit/{id}',
            'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@edit')
        ->defaults('_config', [
            'view' => 'mpstorelocator::admin.stores.edit',
        ])->name('admin.mpstorelocator.stores.edit');

        Route::post('/stores/update/{id}', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@update')
        ->defaults('_config', [
            'redirect' => 'admin.mpstorelocator.stores',
        ])
        ->name('admin.mpstorelocator.stores.update');

        Route::get('/stores/assign-product/{id}', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@assignProduct')
        ->defaults('_config', [
            'view' => 'mpstorelocator::admin.stores.assign-product',
        ])->name('admin.mpstorelocator.stores.assign-product');
/* 
        Route::get('/stores/assign-product/{id}', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@assignProduct')
        ->defaults('_config', [
            'view' => 'mpstorelocator::admin.stores.assign-product',
        ])->name('admin.mpstorelocator.stores.assign-product'); */

        Route::match(['get', 'post'] , '/stores/assign-stores/{productid}', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@assignStores')
        ->defaults('_config', [
            'view' => 'mpstorelocator::admin.products.assign-stores',
        ])->name('admin.mpstorelocator.stores.assign-stores');


        Route::post('/stores/remove-product/', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@removeProducts')
        ->defaults('_config', [
            'view' => 'mpstorelocator::admin.stores.assign-product',
        ])->name('admin.mpstorelocator.stores.remove-product');

        Route::post('/stores/remove-stores/', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@removeStoresFromProduct')
         ->name('admin.mpstorelocator.stores.remove-stores');

        Route::post('/stores/delete/{id}', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@destroy')
        ->name('admin.mpstorelocator.stores.delete');

        Route::post('/stores/store', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@store')->defaults('_config', [
            'redirect' => 'admin.mpstorelocator.stores',
        ])->name('admin.mpstorelocator.stores.store');

        Route::post('/stores/mass-status-update', 'Webkul\MpStoreLocator\Http\Controllers\Admin\HolidaysController@massChangeStatus')->name('admin.mpstorelocator.stores.mass-status-update');


        /*END: Manage Stores routes end*/

        /*Beginning Store pickup stores */
        Route::get('/pickup-store-order', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@index')->defaults('_config', [
            'view' => 'mpstorelocator::admin.store-pickup-orders.list',
        ])->name('admin.mpstorelocator.pickup-store-order');
        /*End Store pickup*/

        Route::get('/manage-holidays', 'Webkul\MpStoreLocator\Http\Controllers\Admin\MpStoreLocatorController@index')->defaults('_config', [
            'view' => 'mpstorelocator::admin.holidays.list',
        ])->name('admin.mpstorelocator.manage-holidays');
        
        Route::get('/manage-holidays/create', 'Webkul\MpStoreLocator\Http\Controllers\Admin\HolidaysController@create')
        ->defaults('_config', [
            'view' => 'mpstorelocator::admin.holidays.create',
        ])->name('admin.mpstorelocator.manage-holidays.create');

        Route::post('/manage-holidays/store', 'Webkul\MpStoreLocator\Http\Controllers\Admin\HolidaysController@store')->name('admin.mpstorelocator.manage-holidays.store');

        Route::post('/manage-holidays/delete/{id}', 'Webkul\MpStoreLocator\Http\Controllers\Admin\HolidaysController@destroy')
            ->name('admin.mpstorelocator.manage-holidays.delete');

        Route::get('/manage-holidays/edit/{id}', 'Webkul\MpStoreLocator\Http\Controllers\Admin\HolidaysController@edit')
            ->defaults('_config', [
                'view' => 'mpstorelocator::admin.holidays.edit',
            ])
        ->name('admin.mpstorelocator.manage-holidays.edit');

        Route::post('/manage-holidays/update/{id}', 'Webkul\MpStoreLocator\Http\Controllers\Admin\HolidaysController@update')->name('admin.mpstorelocator.manage-holidays.update');

        Route::post('/manage-holidays/mass-delete', 'Webkul\MpStoreLocator\Http\Controllers\Admin\HolidaysController@store')->name('admin.mpstorelocator.manage-holidays.massdelete');

        Route::post('/manage-holidays/mass-status-update', 'Webkul\MpStoreLocator\Http\Controllers\Admin\HolidaysController@massChangeStatus')->name('admin.mpstorelocator.manage-holidays.mass-status-update');


        

});