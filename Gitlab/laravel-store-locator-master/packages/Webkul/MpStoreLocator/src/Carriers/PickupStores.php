<?php

namespace Webkul\Shipping\Carriers;

use Config;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Checkout\Facades\Cart;

/**
 * Class Rate.
 *
 */
class PickupStores extends AbstractShipping
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'pickup_store';

    /**
     * Returns rate for flatrate
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        $cart = Cart::getCart();

        $object = new CartShippingRate;
        $object->carrier = 'pickup_store';
        $object->carrier_title = $this->getConfigData('title') ?? trans('mpstorelocator::app.title');
        $object->method = 'pickup_store_pickup_store';
        $object->method_title = $this->getConfigData('method_name') ?? trans('mpstorelocator::app.method_name');
        $object->method_description =  ($this->getConfigData('method_name') ?? trans('mpstorelocator::app.method_name'))." ".trans('mpstorelocator::app.shipping') ;
        $object->is_calculate_tax = 0;
        $object->price = 10;
        $object->base_price = core()->getConfigData('sales.carriers.pickup_store.handling_fee') ?? 0; 

        if ($this->getConfigData('type') == 'per_unit') {
            foreach ($cart->items as $item) {
                if ($item->product->getTypeInstance()->isStockable()) {
                    $object->price += core()->convertPrice($this->getConfigData('default_rate')) * $item->quantity;
                    $object->base_price += $this->getConfigData('default_rate') * $item->quantity;
                }
            }
        } else {
            $object->price = 10;
            $object->base_price = core()->getConfigData('sales.carriers.pickup_store.handling_fee') ?? 0;
        }

        return $object;
    }
}