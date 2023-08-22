<?php

namespace Webkul\MpStoreLocator\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class MpStoreLocatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'mpstorelocator');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'mpstorelocator');
        
        $this->publishes([
            __DIR__ . '/../Export/' =>   'packages/Webkul/Admin/src/DataGrids',
        ]);
        
        $this->publishes([
            __DIR__ . '/../Resources/assets/images/store-locator-icon' => public_path('themes/default/assets/images'),
        ], 'public');
        
        $packageStatus = !empty(core()->getConfigData('sales.carriers.pickup_store.active')) ? core()->getConfigData('sales.carriers.pickup_store.active') : 0;
        
        $this->publishes([
            __DIR__ . '/../Resources/views/admin/layouts/nav-left.blade.php' => resource_path('views/vendor/admin/layouts/nav-left.blade.php'),
        
            __DIR__ . '/../Resources/views/shop/velocity/checkout/onepage/shipping.blade.php' => resource_path('themes/velocity/views/checkout/onepage/shipping.blade.php'),
        
            __DIR__ . '/../Resources/views/shop/velocity/checkout/onepage.blade.php' => resource_path('themes/velocity/views/checkout/onepage.blade.php'),

            __DIR__ . '/../Resources/views/shop/velocity/layouts/header/mobile.blade.php' => resource_path('themes/velocity/views/shop/layouts/header/mobile.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Carriers/' =>  'packages/Webkul/Shipping/src/Carriers',
        ]);

        if ($packageStatus == 1) {

            Event::listen('checkout.order.save.after', 'Webkul\MpStoreLocator\Http\Controllers\Shop\MpStoreLocatorController@saveOrderStorePicker');

            Event::listen(
                [
                    'bagisto.shop.layout.header.cart-item.after',
                ],
                function ($viewRenderEventManager) {
                    $viewRenderEventManager->addTemplate('mpstorelocator::shop.website.stores_pickup');
                }
            );

            Event::listen(
                [
                    'bagisto.admin.catalog.product.edit_form_accordian.additional_views.before',
                ],
                function ($viewRenderEventManager) {
                    $viewRenderEventManager->addTemplate('mpstorelocator::admin.products.stores_locators');
                }
            );

            Event::listen('bagisto.admin.layout.head', function ($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate('mpstorelocator::admin.layouts.style');
            });
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php',
            'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php',
            'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php',
            'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/carriers.php',
            'carriers'
        );
    }
}
