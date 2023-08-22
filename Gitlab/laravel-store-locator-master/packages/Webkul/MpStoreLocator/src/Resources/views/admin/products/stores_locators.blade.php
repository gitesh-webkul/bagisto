
@php
$storeLocators =  \Webkul\MpStoreLocator\Models\StoresModel::getProductStoresLocators($product->id);
$storeLocatorIds = $storeLocators->pluck('id')->all();
@endphp
<accordian title="Assign Pickup Store" :active="true">
    <div slot="body" id="suppliersProducts">
        <suppliers-form-div></suppliers-form-div>
    </div>
</accordian>
@push('scripts')
    <script type="text/x-template" id="suppliers-form-div-template">
        <div>
            <div class="control-group">
                <a href="{{ route('admin.mpstorelocator.stores.assign-stores',[$product->id]) }}" 
                    target="_blank"
                    class="btn btn-lg btn-primary addNewSupplier" @click="addSuppliers()">
                    {{ __('mpstorelocator::app.admin.assign_pickup_locators') }}
                    </label>
                </a>
            </div>
            <table id="customers" class="table" style="width:100%;">
                <tbody class="control-group">
                    <thead>
                        <tr>
                            <th>{{ __('mpstorelocator::app.admin.store_name') }}</th>
                            <th> {{ __('mpstorelocator::app.admin.status') }} </th>
                            <th> {{ __('mpstorelocator::app.admin.latitude') }}</th>
                            <th> {{ __('mpstorelocator::app.admin.longitude') }}</th>
                            <th> {{ __('mpstorelocator::app.admin.person_name') }}</th>
                            <th> {{ __('mpstorelocator::app.admin.action') }}</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(stores , storesIndex) in storesLocators">
                           
                            <td>@{{stores.store_name }}</td>
                            <td>@{{stores.status }}</td>
                            <td>@{{stores.store_lat }}</td>
                            <td>@{{stores.store_long }}</td>
                            <td>@{{stores.person_name }}</td>
                            <td class="actions">
                                <i class="icon trash-icon" 
                                    :data-productid="{{$product->id}}"
                                    :data-storeid="stores.id"
                                    @click="removeStores()"></i>
                            </td>
                        </tr>
                    </tbody>
                </tbody>
            </table>
           
        </div>
    </script>
    <script>
        Vue.component('suppliers-form-div', {
            data: function() {
                return {
                    defaultSuppliersIndex: 0,
                    storesLocators: @json($storeLocators),
                    lengthOfSuppliers: @json($storeLocatorIds),
                }
            },
            template: '#suppliers-form-div-template',
            methods: {
                removeStores:function(){
                    let con = confirm("Are you sure want to delete this item?");
                    if(con == true){
                        var storeId = event.target.getAttribute('data-storeid');;
                        var productId = event.target.getAttribute('data-productid');;
                       
                        var thisAssign = this;
                        this.$http.post("{{ route('admin.mpstorelocator.stores.remove-stores') }}", {
                            params: {
                                query: {'product_id':productId,'storeid':storeId}
                            }
                        })
                        .then(function(response) {
                            console.log(response)
                            if(response.status == 200){
                                thisAssign.storesLocators = response.data.response;
                            }
                        })
                        .catch(function(error) {
                            console.log(error)
                        })
                    }
                }
                
              
            },
            mounted: function() {
                    console.log(this.storesLocators)
               
            }
        });
    </script>
@endpush
@section('css')
<style>
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }
    
    #customers tr:nth-child(even){background-color: #f2f2f2;}
    
    #customers tr:hover {background-color: #ddd;}
    
    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
</style>
@stop
