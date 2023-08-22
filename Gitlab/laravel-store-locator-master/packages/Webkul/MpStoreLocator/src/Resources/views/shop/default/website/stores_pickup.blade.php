@if(core()->getConfigData('sales.carriers.pickup_store.show_pickup_stores_page') == "Y")
<li class="compare-dropdown-container">
    <span>
        <i class="icon account-icon"></i>
        <a style="color: rgb(36, 36, 36);" href="{{ route('pickup-stores.index') }}">
            <span
                class="name">{{ __('mpstorelocator::app.shop.pickup_store') }}</span>
        </a>
    </span>
</li>
@endif
