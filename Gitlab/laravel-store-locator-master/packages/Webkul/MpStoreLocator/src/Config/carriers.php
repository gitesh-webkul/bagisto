<?php
use Illuminate\Support\Facades\Config;

    return [
        'stores_pickup' =>[
            'code'             => 'stores_pickup',
            'title'            => 'Stores Pickup',
            'description'      => 'Stores Pickup Shipping',
            'active'           => false,
            'is_calculate_tax' => true,
            'default_rate'     => '10',
            'type'             => null,
            'class'            => 'Webkul\Shipping\Carriers\PickupStores',
        ]
    ];

