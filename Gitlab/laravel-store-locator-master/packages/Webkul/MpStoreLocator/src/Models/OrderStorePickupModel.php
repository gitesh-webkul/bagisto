<?php

namespace Webkul\MpStoreLocator\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MpStoreLocator\Contracts\OrderStorePickupModel as OrderStorePickupModelContract;

class OrderStorePickupModel extends Model implements OrderStorePickupModelContract
{
    protected $table = 'order_store_pickup';

    protected $fillable = [
        'id',
        'order_id',
        'stores_id'
    ];

}
