<?php

return [
    [
        'key'    => 'sales.carriers.pickup_store',
        'name'   => 'Store Locator',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'active',
                'title'         => 'mpstorelocator::app.admin.enabled',
                'type'          => 'boolean',
                
            ],
            [
                'name'          => 'title',
                'title'         => 'mpstorelocator::app.admin.title',
                'type'          => 'text',
            ],
            [
                'name'          => 'method_name',
                'title'         => 'mpstorelocator::app.admin.method_name',
                'type'          => 'text',
            ],
            [
                'name'          => 'calculate_handling_fee',
                'title'         => 'mpstorelocator::app.admin.calculate_handling_fee',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'Fixed',
                        'value' => 'F',
                    ], [
                        'title' => 'Percent',
                        'value' => 'P',
                    ],
                ],

            ],
            [
                'name'          => 'handling_fee',
                'title'         => 'mpstorelocator::app.admin.handling_fee',
                'type'          => 'text',
            ],
            [
                'name'          => 'within_range',
                'title'         => 'mpstorelocator::app.admin.within_range',
                'type'          => 'text',
                'info'          => 'mpstorelocator::app.admin.within_range_info',
            ],
            [
                'name'          => 'show_pickup_stores_page',
                'title'         => 'mpstorelocator::app.admin.show_pickup_stores_page',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'YES',
                        'value' => 'Y',
                    ], [
                        'title' => 'NO',
                        'value' => 'N',
                    ],
                ],
                'info'          => 'mpstorelocator::app.admin.show_pickup_stores_page_info',
            ],
            [
                'name'          => 'enable_address_search',
                'title'         => 'mpstorelocator::app.admin.enable_address_search',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'YES',
                        'value' => 'Y',
                    ], [
                        'title' => 'NO',
                        'value' => 'N',
                    ],
                ],
                'info'          => 'mpstorelocator::app.admin.enable_address_search_info',
            ],
            [
                'name'          => 'enable_scheduling_email',
                'title'         => 'mpstorelocator::app.admin.enable_scheduling_email',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'YES',
                        'value' => 'Y',
                    ], [
                        'title' => 'NO',
                        'value' => 'N',
                    ],
                ],

            ],
            [
                'name'          => 'order_scheduling_template',
                'title'         => 'mpstorelocator::app.admin.order_scheduling_template',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'mpstorelocator::app.admin.order_scheduling_email',
                        'value' => 1,
                    ],
                    [
                        'title' => 'mpstorelocator::app.admin.new_pickup_order',
                        'value' => 2,
                    ],
                    [
                        'title' => 'mpstorelocator::app.admin.new_pickup_order_for_guest',
                        'value' => 3,
                    ],
                ],

            ],
            [
                'name'          => 'display_error_msg',
                'title'         => 'mpstorelocator::app.admin.display_error_msg',
                'type'          => 'textarea',
                'info'   => 'This shipping method is not available. To use this shipping method, please contact us.'

            ],
            [
                'name'          => 'ship_to_applicable_countries',
                'title'         => 'mpstorelocator::app.admin.ship_to_applicable_countries',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'mpstorelocator::app.admin.all_allowed_countries',
                        'value' => 1,
                    ],
                    [
                        'title' => 'mpstorelocator::app.admin.specific_countries',
                        'value' => 2,
                    ],
                   
                ],

            ],
            [
                'name'          => 'ship_to_applicable_countries',
                'title'         => 'mpstorelocator::app.admin.ship_to_applicable_countries',
                'type'          => 'multiselect',
                'options'       => \Webkul\MpStoreLocator\Models\StoresModel::countriesCollection(),

            ],
            [
                'name'          => 'show_method_if_applicable',
                'title'         => 'mpstorelocator::app.admin.show_method_if_applicable',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'YES',
                        'value' => 'Y',
                    ],
                    [
                        'title' => 'NO',
                        'value' => 'N',
                    ],
                   
                ],

            ],
            [
                'name'          => 'sort_order',
                'title'         => 'mpstorelocator::app.admin.sort_order',
                'type'          => 'text',
            ],

        ],
    ],
    [
        'key'    => 'catalog.inventory.distance_provider_for_distance_based_ssa',
        'name'   => 'mpstorelocator::app.admin.distance_provider_for_distance_based_ssa',
        'sort'   => 2,
        'fields' => [
            [
                'name'          => 'providers',
                'title'         => 'mpstorelocator::app.admin.providers',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'mpstorelocator::app.admin.google_map',
                        'value' => 'google_map',
                    ], 
                    [
                        'title' => 'mpstorelocator::app.admin.offline_calculation',
                        'value' => 'offline_calculation',
                    ],
                  
                ],
            ],
        ],
       
    ], 
    [
        'key'    => 'catalog.inventory.google_distance_provider',
        'name'   => 'mpstorelocator::app.admin.google_distance_provider',
        'sort'   => 2,
        'fields' => [
            [
                'name'          => 'google_api_key',
                'title'         => 'mpstorelocator::app.admin.google_api_key',
                'type'          => 'text',
                'info'          => 'mpstorelocator::app.admin.google_api_key_info',
            ],
            [
                'name'          => 'computation_mode',
                'title'         => 'mpstorelocator::app.admin.computation_mode',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'mpstorelocator::app.admin.driving',
                        'value' => 'driving',
                    ], 
                    [
                        'title' => 'mpstorelocator::app.admin.walking',
                        'value' => 'walking',
                    ],
                    [
                        'title' => 'mpstorelocator::app.admin.bicycling',
                        'value' => 'bicycling',
                    ],
                ],
            ],
            [
                'name'          => 'computation_mode_value',
                'title'         => 'mpstorelocator::app.admin.computation_mode_value',
                'type'          => 'select',
                'options'       => [
                    [
                        'title' => 'mpstorelocator::app.admin.distance',
                        'value' => 'distance',
                    ], 
                    [
                        'title' => 'mpstorelocator::app.admin.time_to_destination',
                        'value' => 'time_to_destination',
                    ],
                    
                ],
            ],
        ],
       
    ], 



];
