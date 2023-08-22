@php
    $stores  = \Webkul\MpStoreLocator\Models\StoresModel::getStoresmodel();
@endphp
<table class="table" style="display: none;">
    <thead>
        <tr>
            <th colspan="2"> {{ __('mpstorelocator::app.shop.stores_locators') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stores as $store)
            <tr>
                <td>
                    <input type="radio" 
                        name="shipping_method" 
                        id="pickup_store_pickup_store{{$store->id}}" 
                        value="pickup_store_pickup_store" 
                        data-vv-as="&quot;Select Shipping Method&quot;" 
                        aria-required="true" 
                        aria-invalid="false" />&nbsp;
                        <label for="pickup_store_pickup_store{{$store->id}}">
                            {{$store->store_name ?? '--'}}
                        </label>
                    </td>
                <td>0.5Km</td>
            </tr>
        @endforeach
    </tbody>
</table>

<stores-locators></stores-locators>
@push('scripts')
    <script>
        $(document).ready(function(){
            $(document).on('click','#pickup_store_pickup_store',function(){
                alert("working")
            });
        });
    </script>
    <script type="text/x-template" id="stores-locators-template">
        <div>
            <h1>Working</h1>
        </div>
    </script>
    <script>
        Vue.component('stores-locators', {
            data: function() {
                return {
                  
                }
            },
            template: '#stores-locators-template',
            methods: {
                
              
            },
        });
    </script>
@endpush
