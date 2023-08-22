
<form data-vv-scope="shipping-form" class="shipping-form">
    <div class="form-container">
        <accordian :title="'{{ __('shop::app.checkout.onepage.shipping_method') }}'" :active="true">
            <div class="form-header" slot="header">
                <h3 class="fw6 display-inbl">
                 {{ __('shop::app.checkout.onepage.shipping-method') }}
                </h3>
                <i class="rango-arrow"></i>
            </div>
            <div :class="`shipping-methods ${errors.has('shipping-form.shipping_method') ? 'has-error' : ''}`" slot="body">
                @foreach ($shippingRateGroups as $rateGroup)
                    {!! view_render_event('bagisto.shop.checkout.shipping-method.before', ['rateGroup' => $rateGroup]) !!}
                        @foreach ($rateGroup['rates'] as $rate)
                            <div class="row col-12">
                                <div>
                                    <label class="radio-container">
                                        <input
                                            type="radio"
                                            v-validate="'required'"
                                            name="shipping_method"
                                            id="{{ $rate->method }}"
                                            value="{{ $rate->method }}"
                                            @change="methodSelected()"
                                            v-model="selected_shipping_method"
                                            data-vv-as="&quot;{{ __('shop::app.checkout.onepage.shipping-method') }}&quot;" />
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="pl30">
                                    <div class="row">
                                        <b>{{ core()->currency($rate->base_price) }}</b>
                                    </div>

                                    <div class="row">
                                        <b>{{ $rate->method_title }}</b> - {{ __($rate->method_description) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    {!! view_render_event('bagisto.shop.checkout.shipping-method.after', ['rateGroup' => $rateGroup]) !!}
                @endforeach
                <span
                    class="control-error"
                    v-if="errors.has('shipping-form.shipping_method')"
                    v-text="errors.first('shipping-form.shipping_method')">
                </span>
                <table class="table" v-if="storeLocators">
                    <thead>
                        <tr>
                            <th colspan="2">{{ __('mpstorelocator::app.shop.store_locators') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(stores , storeIndex) in storesLocatorsArr" v-if="(storesLocatorsArr.length > 0)">
                            <td style="width: 5%">
                                <input type="radio" 
                                    name="shipping_store_name" 
                                    :id="`pickup_store_pickup_store${storeIndex}`" 
                                    :value="stores.id" 
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.shop.select_shipping_pickup_stores') }} &quot;" 
                                    aria-required="true" 
                                    @change="methodSelectedStorePickup($event)"
                                    aria-invalid="false" />&nbsp;
                            </td>
                            <td style="width: 20%">
                                <label :for="'pickup_store_pickup_store'+storeIndex">
                                    @{{stores.store_name}}
                                </label>
                            </td>
                            <td>
                                @{{stores.address_street}} @{{stores.address_city}} @{{stores.address_state}}  
                                @{{stores.address_country}}  @{{stores.address_postal_code}}  (  @{{stores.distance.toFixed(2)}} Km)
                            </td>
                        </tr>
                        <tr v-if="(storesLocatorsArr.length == 0)">
                            <td colspan="2">
                                {{ __('mpstorelocator::app.shop.no_stores_pickup_available') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </accordian>
    </div>
</form>

