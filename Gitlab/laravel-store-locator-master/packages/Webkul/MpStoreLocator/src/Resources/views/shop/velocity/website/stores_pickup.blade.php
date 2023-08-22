@if(core()->getConfigData('sales.carriers.pickup_store.show_pickup_stores_page') == "Y")
<a href="{{ route('pickup-stores.index')}}" class="wishlist-btn unset">
    <i class="material-icons">favorite_borders</i>
<span>{{ __('mpstorelocator::app.shop.pickup_store') }}</span></a>
@endif