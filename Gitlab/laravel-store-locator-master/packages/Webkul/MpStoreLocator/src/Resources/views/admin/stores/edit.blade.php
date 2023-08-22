@extends('admin::layouts.content')
@section('page_title')
    {{ __('mpstorelocator::app.admin.stores') }}
@stop
@push('css')
@endpush
@section('content')
    <div class="content full-page dashboard">
        <form method="POST" action="{{ route('admin.mpstorelocator.stores.update',[$stores->id]) }}" @submit.prevent="onSubmit">
            <div class="page-header">

                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link"
                            onclick="window.location = '{{ route('admin.mpstorelocator.index') }}'"></i>
                        {{ __('mpstorelocator::app.admin.new_stores') }}
                    </h1>
                </div>
                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('mpstorelocator::app.admin.save_stores') }}
                    </button>
                </div>
             
            </div>

            <div class="page-content">
                <div class="form-container">
                    <accordian :title="'{{ __('mpstorelocator::app.admin.store_info') }}'" :active="true">
                        <div slot="body">         
                            <div class="control-group" :class="[errors.has('attribute_label') ? 'has-error' : '']">
                                <label for="attribute_label">
                                    {{ __('mpstorelocator::app.admin.status') }}</label>
                                <select 
                                    name="status" 
                                    class="control" 
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.status') }}&quot;">
                                        <option value="A" {{ ($stores->status == 'A') ? 'selected':''}}>{{ __('mpstorelocator::app.admin.enabled') }}
                                        </option>
                                        <option value="D" {{ ($stores->status == 'D') ? 'selected':''}}>{{ __('mpstorelocator::app.admin.disabled') }}
                                        </option>
                                </select>
                            </div>
                            <div class="control-group" 
                                :class="[errors.has('store_name') ? 'has-error' : '']">
                                <label for="store_name"
                                    class="required">{{ __('mpstorelocator::app.admin.store_name') }}</label>
                                <input type="text" 
                                    class="control" 
                                    name="store_name" 
                                    v-validate="'required'"
                                    value="{{ old('store_name') ?? $stores->store_name}}"
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.store_name') }}&quot;" />
                                <span class="control-error"
                                    v-if="errors.has('store_name')">@{{ errors.first('store_name') }}</span>
                            </div>
                        </div>
                    </accordian>
                    <accordian :title="'{{ __('mpstorelocator::app.admin.store_location') }}'" :active="true">
                        <div slot="body">     
                            <div class="control-group" :class="[errors.has('latitude') ? 'has-error' : '']">
                                <label for="latitude"
                                    class="required">{{ __('mpstorelocator::app.admin.latitude') }}</label>
                                <input 
                                    type="text" 
                                    class="control" 
                                    id="latitude" 
                                    name="latitude" 
                                    v-validate="'required'"
                                    value="{{ old('latitude') ?? $stores->store_lat}}"
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.latitude') }}&quot;">
                                <span class="control-error"
                                    v-if="errors.has('latitude')">@{{ errors.first('latitude') }}</span>
                            </div>
                            <div class="control-group" 
                                :class="[errors.has('longitude') ? 'has-error' : '']">
                                <label for="longitude"
                                    class="required">{{ __('mpstorelocator::app.admin.longitude') }}</label>
                                <input type="text" 
                                    class="control" 
                                    id="longitude" 
                                    name="longitude" 
                                    v-validate="'required'"
                                    value="{{ old('longitude') ?? $stores->store_long }}"
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.longitude') }}&quot;">
                                <span class="control-error"
                                    v-if="errors.has('longitude')">@{{ errors.first('longitude') }}</span>
                            </div>
                            <div class="control-group" :class="[errors.has('longitude') ? 'has-error' : '']">
                                <button type="button" style=" color: #2D2727;" class="btn btn-lg btn-default text-muted">
                                    {{ __('mpstorelocator::app.admin.get_current_location_lat_long') }}
                                </button>
                            </div>
                            <div class="control-group" 
                                :class="[errors.has('description') ? 'has-error' : '']">
                                <label for="description"
                                    class="required">{{ __('mpstorelocator::app.admin.description') }}</label>
                                <textarea 
                                    type="text" 
                                    class="control" 
                                    id="description" 
                                    name="description"
                                    v-validate="'required'" 
                                    value="{{ old('description') ?? $stores->description }}"
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.description') }}&quot;">{{$stores->description ?? 
                                    ''}}</textarea>
                            <br />
                              <span>{{ __('mpstorelocator::app.admin.description_will_not_show_on_frontend') }}</span>
                                <span class="control-error"
                                    v-if="errors.has('description')">@{{ errors . first('description') }}</span>
                            </div>
                        </div>    
                    </accordian>
                </div>
            </div>

            <store-time-div></store-time-div>

        </form>
    </div>
@stop
@push('scripts')

    <script type="text/x-template" id="store-time-div-template">
        <div>
            <accordian :title="'{{ __('mpstorelocator::app.admin.store_timing') }}'" :active="true">
                <div slot="body"> 
                    <div class="control-group">
                        <label for="urgent_closed">
                            {{ __('mpstorelocator::app.admin.urgent_closed') }}</label>
                        <select 
                            name="urgent_closed" 
                            class="control" 
                            v-model="stores.urgent_closed">
                            <option value="Y">{{ __('mpstorelocator::app.admin.yes') }}
                            </option>
                            <option value="N">{{ __('mpstorelocator::app.admin.no') }}
                            </option>
                        </select>
                        <span class="control-error"
                            v-if="errors.has('urgent_closed')">@{{ errors . first('urgent_closed') }}</span>
                    </div>                         
                    <div class="control-group" :class="[errors.has('store_opens') ? 'has-error' : '']">
                        <label for="store_opens" class="required">
                            {{ __('mpstorelocator::app.admin.store_opens') }}</label>
    
                        <select name="store_opens" 
                            class="control" 
                            v-model="stores.store_opens"
                            id="store_opens"
                            @change="selectStoresOpens($event)"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.store_opens') }}&quot;">
                            <option value="1">{{ __('24*7') }}</option>
                            <option value="2">{{ __('mpstorelocator::app.admin.custom_days_with_same_timing') }}</option>
                            <option value="3">{{ __('mpstorelocator::app.admin.custom_days_with_custom_timing') }}</option>
                        </select>
                        <span class="control-error" 
                            v-if="errors.has('urgent_closed')">@{{ errors . first('urgent_closed') }}</span>
                    </div>
                    <div class="control-group">
                        <div class="all_day_same_timing" v-if="stores.customDaySameTiming">
                            <label for="store_opens" class="required">
                                {{ __('mpstorelocator::app.admin.timings') }}</label>
                            <table>
                                <tr>
                                    <td>
                                        <time-component style="pull:left;">
                                            <input type="text" 
                                                :name="'timing[start_time]'" 
                                                v-model="stores.same_time.start_time" 
                                                class="control" 
                                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.start_time') }}&quot;">
                                        </time-component>
                                    </td>
                                    <td>
                                        <time-component style="pull:right;">
                                            <input type="text"
                                                :name="'timing[end_time]'" 
                                                v-model="stores.same_time.start_time" 
                                                class="control" 
                                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.end_time') }}&quot;">
                                        </time-component>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr style="background-color:#DED9D9;">
                                    <td style="text-align:center; padding:15px;" 
                                        colspan="2">{{ __('mpstorelocator::app.admin.days') }} </td>
                                </tr>
                                <tr v-for="(day , dayIndex) in weekdaysArr">
                                    <td >
                                        <input type="checkbox" 
                                            :name="'timing[days]['+dayIndex+']'"
                                            style="width:15px;height:16px; margin-right:25px;"
                                            class="booking_weekday"
                                            :checked="day.activeWeekDay"
                                            :value="dayIndex"
                                           > 
                                    </td>
                                    <td style="margin-left:25px;">
                                        @{{day.name}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="all_day_different_timing" v-if="stores.customDayDifferentTiming">
                            <table>
                                <tr style="background-color:#DED9D9;">
                                    <td colspan="2" style="text-align:center; padding:15px;">{{ __('mpstorelocator::app.admin.days') }} </td>
                                    <td colspan="2" style="text-align:center">{{ __('mpstorelocator::app.admin.timing') }} </td>
                                </tr>
                                <tr v-for="(day , dayIndex) in weekdaysArr">
                                    <td>
                                        <input type="checkbox" 
                                            :name="'timing['+dayIndex+']'"
                                            style="width:15px;height:16px; margin-right:25px;"
                                            class="booking_weekday"
                                            :checked="day.activeWeekDay"
                                           > 
                                    </td>
                                    <td style="margin-left:25px;">
                                        @{{day.name}}
                                    </td>
                                    <td style="margin-left:25px;">
                                        <time-component style="pull:left;">
                                            <input type="text" 
                                                :name="'timing['+dayIndex+'][start_time]'" 
                                                style="margin-left:20px;"
                                                class="control" 
                                                v-model="day.weekDaySlots.from" 
                                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.start_time') }}&quot;">
                                        </time-component>
                                    </td>
                                    <td stmodelyle="margin-left:25px;">
                                        <time-component style="pull:left;">
                                            <input type="text"
                                                :name="'timing['+dayIndex+'][end_time]'"  
                                                class="control" 
                                                v-model="day.weekDaySlots.to" 
                                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.start_time') }}&quot;">
                                        </time-component>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </accordian>
            <accordian :title="'{{ __('mpstorelocator::app.admin.store_holidays') }}'" :active="true">
                <div slot="body"> 
                    <div class="control-group">
                        <label for="store_holidays">
                            {{ __('mpstorelocator::app.admin.store_holidays') }}</label>
                        <select name="store_holidays" 
                            v-model="stores.multipleHolidays"
                            class="control" 
                            multiple
                            name="stores_holidays[]">
                            @foreach ($holidays as $holiday)
                                <option value="{{$holiday->id}}">{{$holiday->name}}</option>
                            @endforeach
                        </select>
                    </div>                         
                </div>
            </accordian>
            <accordian :title="'{{ __('mpstorelocator::app.admin.contact_info') }}'" :active="true">
                <div slot="body"> 
                    <div class="control-group" 
                        :class="[errors.has('person_name') ? 'has-error' : '']">
                        <label for="person_name"
                            class="required">{{ __('mpstorelocator::app.admin.person_name') }}</label>
                        <input type="text" 
                            class="control" 
                            v-model="stores.person_name"
                            name="person_name" 
                            v-validate="'required'"
                            value="{{ old('person_name') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.person_name') }}&quot;">
                        <span class="control-error"
                            v-if="errors.has('person_name')">@{{ errors.first('person_name') }}</span>
                    </div>              
                    <div class="control-group" 
                        :class="[errors.has('email') ? 'has-error' : '']">
                        <label for="email"
                            class="required">{{ __('mpstorelocator::app.admin.email') }}</label>
                        <input type="text" 
                            class="control" 
                            v-model="stores.email"
                            name="email" 
                            v-validate="'required'"
                            value="{{ old('email') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.email') }}&quot;">
                        <span class="control-error"
                            v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                    </div>              
                    <div class="control-group" 
                        :class="[errors.has('mobile') ? 'has-error' : '']">
                        <label for="mobile"
                            class="required">{{ __('mpstorelocator::app.admin.mobile') }}</label>
                        <input type="text" 
                            class="control" 
                            v-model="stores.mobile"
                            name="mobile" 
                            v-validate="'required'"
                            value="{{ old('mobile') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.mobile') }}&quot;">
                        <span class="control-error"
                            v-if="errors.has('mobile')">@{{ errors.first('mobile') }}</span>
                    </div>              
                    <div class="control-group">
                        <label for="mobile"
                           >{{ __('mpstorelocator::app.admin.fax') }}</label>
                        <input type="text" 
                            class="control" 
                            v-model="stores.fax"
                            name="fax" 
                            value="{{ old('fax') }}"
                          >
                        <span class="control-error"
                            v-if="errors.has('fax')">@{{ errors.first('fax') }}</span>
                    </div>              
                </div>
            </accordian>
            <accordian :title="'{{ __('mpstorelocator::app.admin.address_data') }}'" :active="true">
                <div slot="body"> 
                    <div class="control-group" 
                    :class="[errors.has('country') ? 'has-error' : '']">
                        <label for="country" 
                            class="required">{{ __('mpstorelocator::app.admin.country') }}</label>
                        <select class="control" 
                                v-model="stores.country"
                                @change="getState($event)" 
                                name="country">
                            <option value="">{{ __('mpstorelocator::app.admin.select_country') }}</option>
                            @foreach (core()->countries() as $country)
                                <option value="{{ $country->code }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <span class="control-error" v-if="errors.has('country')">@{{ errors.first('country') }}</span>
                    </div>
                 
                    <div class="control-group" 
                    :class="[errors.has('state_province') ? 'has-error' : '']">
                        <label for="state_province" 
                            class="required">{{ __('mpstorelocator::app.admin.state_province') }}</label>
                        <select class="control" 
                            v-if="isState"  
                            v-validate="'required'" 
                            v-model="stores.state_province"
                            name="state_province">
                            <option  
                                v-for="(state, stateIndex) in statesArr" 
                                :value="state.default_name"
                                >@{{state.default_name}}</option>

                        </select>
                        <input type="text" 
                            v-if="!isState"
                            v-model="stores.state_province"
                            class="control" 
                            name="state_province" 
                            v-validate="'required'"
                            value="{{ old('state_province') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.state_province') }}&quot;">
                    </div>            
                              
                    <div class="control-group" 
                        :class="[errors.has('city') ? 'has-error' : '']">
                        <label for="city" 
                            class="required">{{ __('mpstorelocator::app.admin.city') }}</label>
                        <input type="text" 
                            class="control" 
                            v-model="stores.city"
                            name="city" 
                            v-validate="'required'"
                            value="{{ old('city') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.city') }}&quot;">
                        <span class="control-error" v-if="errors.has('city')">@{{ errors.first('city') }}</span>
                    </div>            
                    <div class="control-group" 
                        :class="[errors.has('street') ? 'has-error' : '']">
                        <label for="street" 
                            class="required">{{ __('mpstorelocator::app.admin.street') }}</label>
                        <input type="text" 
                            class="control" 
                            v-model="stores.street"
                            name="street" 
                            v-validate="'required'"
                            value="{{ old('street') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.street') }}&quot;">
                        <span class="control-error" v-if="errors.has('street')">@{{ errors.first('street') }}</span>
                    </div>            
                    <div class="control-group" 
                        :class="[errors.has('postal_code') ? 'has-error' : '']">
                        <label for="postal_code" 
                            class="required">{{ __('mpstorelocator::app.admin.postal_code') }}</label>
                        <input type="text" 
                            v-model="stores.postal_code"
                            class="control" 
                            name="postal_code" 
                            v-validate="'required'"
                            value="{{ old('postal_code') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.postal_code') }}&quot;">
                        <span class="control-error" v-if="errors.has('postal_code')">@{{ errors.first('postal_code') }}</span>
                    </div>               
                </div>
            </accordian>
        
            <accordian :title="'{{ __('mpstorelocator::app.admin.product_assignment') }}'" :active="true">
                <div slot="body"> 
                    <div class="page-action">
                        <a href="{{ route('admin.mpstorelocator.stores.assign-product',[$stores->id])}}" 
                                class="btn btn-lg btn-primary">
                            {{ __('mpstorelocator::app.admin.assign_product') }}
                        </a>
                    </div>

                    <div class="page-content">
                        @if($storeProducts->count() > 0)
                            <table id="customers">
                                <thead>
                                    <tr>
                                        <th> {{ __('mpstorelocator::app.admin.product_id') }}     </th>
                                        <th> {{ __('mpstorelocator::app.admin.product_number') }} </th>
                                        <th> {{ __('mpstorelocator::app.admin.name') }} </th>
                                        <th> {{ __('mpstorelocator::app.admin.sku') }} </th>
                                        <th> {{ __('mpstorelocator::app.admin.action') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product , productIndex) in assignedProducts">
                                        <td>@{{product.product_id}}</td>
                                        <td>@{{product.product_number}}</td>
                                        <td>@{{product.product_name}}</td>
                                        <td>@{{product.product_sku}}</td>
                                        <td>
                                            <a  href="#"
                                                    :data-productid="product.product_id"
                                                    :data-storeid="{{$stores->id}}">
                                                    <span 
                                                        @click.prevent="deleteItem()"
                                                        :data-productid="product.product_id"
                                                        :data-storeid="{{$stores->id}}"
                                                        class="icon trash-icon"></span>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>     
                </div>
            </accordian>
            </div>
        </script>
    <script>
        Vue.component('store-time-div', {
            inject: ['$validator'],
            data: function() {
                return {
                    isState:false,
                    assignedProducts:@json($storeProducts),
                    statesArr:[],
                    stores:{
                        urgent_closed:"{{$stores->urgent_closed}}",
                        store_opens:"{{$stores->store_opens}}",
                        multipleHolidays:@json($holidaysList),
                        same_time:{
                            start_time: '',
                            end_time  : '',
                        },
                        person_name:"{{$stores->person_name}}",
                        email:"{{$stores->person_email}}",
                        mobile:"{{$stores->person_mobile}}",
                        fax:"{{$stores->person_fax}}",
                        country:"{{$stores->address_country}}",
                        city:"{{$stores->address_city}}",
                        postal_code:"{{$stores->address_postal_code}}",
                        street:"{{$stores->address_street}}",
                        state_province:"{{$stores->address_state}}",
                        customDayDifferentTiming: false,
                        customDaySameTiming: false,
                    },
                    weekdaysArr: [
                        {
                            'name': "{{ __('mpstorelocator::app.admin.sunday') }}",
                            'activeWeekDay': false,
                            'weekDaySlots': {
                                'from': '',
                                'to': ''
                            }
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.monday') }}",
                            'activeWeekDay': false,
                            'weekDaySlots': {
                                'from': '',
                                'to': ''
                            }
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.tuesday') }}",
                            'activeWeekDay': false,
                            'weekDaySlots': {
                                'from': '',
                                'to': ''
                            }
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.wednesday') }}",
                            'activeWeekDay': false,
                            'weekDaySlots': {
                                'from': '',
                                'to': ''
                            }
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.thursday') }}",
                            'activeWeekDay': false,
                            'weekDaySlots': [{
                                'from': '',
                                'to': ''
                            }]
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.friday') }}",
                            'activeWeekDay': false,
                            'weekDaySlots': {
                                'from': '',
                                'to': ''
                            }
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.saturday') }}",
                            'activeWeekDay': false,
                            'weekDaySlots': {
                                'from': '',
                                'to': ''
                            }
                        }
                    ],
                }
            },
            template: '#store-time-div-template',
            methods: {
                deleteItem:function(){
                    let con = confirm("Are you sure want to delete this item?");
                    if(con == true){
                        var storeId = event.target.getAttribute('data-storeid');;
                        var productId = event.target.getAttribute('data-productid');;
                       
                        var thisAssign = this;
                        this.$http.post("{{ route('admin.mpstorelocator.stores.remove-product') }}", {
                            params: {
                                query: {'product_id':productId,'storeid':storeId}
                            }
                        })
                        .then(function(response) {
                            console.log(response)
                            if(response.status == 200){
                                thisAssign.assignedProducts = response.data.response;
                            }
                        })
                        .catch(function(error) {
                            console.log(error)
                        })
                    }
                },
                selectStoresOpens: function(event) {
                    if (event.target.value == 1) {
                        this.stores.customDayDifferentTiming = false;
                        this.stores.customDaySameTiming = false;
                    } else if (event.target.value == 2) {
                        this.stores.customDaySameTiming = true;
                        this.stores.customDayDifferentTiming = false;
                    } else if(event.target.value == 3){
                        this.stores.customDaySameTiming = false;
                        this.stores.customDayDifferentTiming = true;
                    }
                },
                removeOptions: function(index) {
                    this.optionsList.splice(index, 1);
                    if (this.optionsList.length == 0) {
                        this.optionsAvailable = false;
                    }
                },
                getState:function(country , countryCode = null){
                    console.log(countryCode)
                    var this_this= this;
                    if(countryCode != null){
                        var country = countryCode;
                    }else{
                        var country = country.target.value;
                    }
                    this_this = this;
                    this.$http.get("{{ route('admin.mpstorelocator.get-state') }}", {
                        params: {
                            query: country
                        }
                    })
                    .then(function(response) {
                        if(response.data.status == 200){
                            this_this.isState = true;
                            this_this.statesArr = response.data.states_provience;
                        }else{
                            this_this.statesArr = [];
                            this_this.isState = false;
                        }
                    })
                    .catch(function(error) {
                        console.log(error)
                    })
                    
                }
            },
            created(){
                var this_this = this;
                let countryCode = "{{$stores->address_country}}";
                this.getState(countryCode , countryCode);
                /*Open days slost*/
                if (this.stores.store_opens == 1) {
                    this.stores.customDayDifferentTiming = false;
                    this.stores.customDaySameTiming = false;
                } else if (this.stores.store_opens == 2) {
                    this.stores.customDaySameTiming = true;
                    this.stores.customDayDifferentTiming = false;
                    Email

                    /*show same timing*/
                    let sameTimeResponse = JSON.parse(@json($stores->same_timing));
                    this.stores.same_time.start_time = sameTimeResponse.start_time;
                    this.stores.same_time.end_time = sameTimeResponse.end_time;
                    //active show checkbox
                    sameTimeResponse.days.forEach(function(daysIndex) {
                       this_this.weekdaysArr[daysIndex].activeWeekDay = true;
                    });
                } else if(this.stores.store_opens == 3){
                    this.stores.customDaySameTiming = false;
                    this.stores.customDayDifferentTiming = true;
                    //show different timing.
                    let diffrentTimeResponse = JSON.parse(@json($stores->different_timing));
                    diffrentTimeResponse.forEach(function(element, index){
                        this_this.weekdaysArr[index].activeWeekDay = true;
                        this_this.weekdaysArr[index].weekDaySlots.from = element.start_time;
                        this_this.weekdaysArr[index].weekDaySlots.to = element.end_time;
                        //let weekResponse =  this_this.weekdaysArr[index].activeWeekDay;
                    });
                }
            },
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
@endsection

