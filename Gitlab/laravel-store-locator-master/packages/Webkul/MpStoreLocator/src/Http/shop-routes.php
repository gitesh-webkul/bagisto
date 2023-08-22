<?php


Route::group([
        'prefix'     => 'pickup-stores',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'Webkul\MpStoreLocator\Http\Controllers\Shop\MpStoreLocatorController@index')->defaults('_config', [
            'view' => 'mpstorelocator::shop.pickup-stores.index',
        ])->name('pickup-stores.index');

        Route::post('/stores-list', 'Webkul\MpStoreLocator\Http\Controllers\Shop\MpStoreLocatorController@storesList')  ->name('pickup-stores.get-stores-list');
  
        Route::post('/set-lat-long', 'Webkul\MpStoreLocator\Http\Controllers\Shop\MpStoreLocatorController@storeLatLong')->name('pickup-stores.set_lat_long');

});