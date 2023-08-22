@extends('admin::layouts.content')
@section('page_title')
    {{ __('mpstorelocator::app.admin.stores') }}
@stop
@push('css')
@endpush
@section('content')
    <div class="content full-page dashboard">
        <form method="POST" action="{{ route('admin.mpstorelocator.stores.store') }}" @submit.prevent="onSubmit">
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
                    @csrf()
                    <accordian :title="'{{ __('mpstorelocator::app.admin.store_info') }}'" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('attribute_label') ? 'has-error' : '']">
                                <label for="attribute_label">
                                    {{ __('mpstorelocator::app.admin.status') }}</label>
                                <select name="status" class="control"
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.status') }}&quot;">
                                    <option value="A">{{ __('mpstorelocator::app.admin.enabled') }}
                                    </option>
                                    <option value="D">{{ __('mpstorelocator::app.admin.disabled') }}
                                    </option>
                                </select>
                            </div>
                            <div class="control-group" :class="[errors.has('store_name') ? 'has-error' : '']">
                                <label for="store_name"
                                    class="required">{{ __('mpstorelocator::app.admin.store_name') }}</label>
                                <input type="text" 
                                    class="control" 
                                    name="store_name" 
                                    v-validate="'required'"
                                    value="{{ old('store_name') }}"
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.store_name') }}&quot;">
                                <span class="control-error"
                                    v-if="errors.has('store_name')">@{{ errors . first('store_name') }}</span>
                            </div>
                        </div>
                    </accordian>
                    <accordian :title="'{{ __('mpstorelocator::app.admin.store_location') }}'" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('latitude') ? 'has-error' : '']">
                                <label for="latitude"
                                    class="required">{{ __('mpstorelocator::app.admin.latitude') }}</label>
                                <input type="text" 
                                    class="control" 
                                    id="latitude" 
                                    name="latitude"
                                    v-validate="'required'" 
                                    value="{{ old('latitude') }}"
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
                                    value="{{ old('longitude') }}"
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.longitude') }}&quot;">
                                <span class="control-error"
                                    v-if="errors.has('longitude')">@{{ errors.first('longitude') }}</span>
                            </div>
                            <div class="control-group">
                                <button type="button" 
                                    style=" color: #2D2727;" 
                                    onclick="getLocation()"
                                    class="btn btn-lg btn-default text-muted">
                                    {{ __('mpstorelocator::app.admin.get_current_location_lat_long') }}
                                </button>
                            </div>
                            <div class="control-group" :class="[errors.has('description') ? 'has-error' : '']">
                                <label for="description"
                                    class="required">{{ __('mpstorelocator::app.admin.description') }}</label>
                                <textarea type="text" 
                                    class="control" 
                                    id="description" 
                                    name="description"
                                    v-validate="'required'" 
                                    value="{{ old('description') }}"
                                    data-vv-as="&quot;{{ __('mpstorelocator::app.admin.description') }}&quot;"></textarea>
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
                    <div class="control-group" :class="[errors.has('urgent_closed') ? 'has-error' : '']">
                        <label for="urgent_closed" class="required">
                            {{ __('mpstorelocator::app.admin.urgent_closed') }}</label>

                        <select name="urgent_closed" 
                            class="control" 
                            id="urgent_closed"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.urgent_closed') }}&quot;">
                            <option value="yes">{{ __('mpstorelocator::app.admin.yes') }}
                            </option>
                            <option value="no">{{ __('mpstorelocator::app.admin.no') }}
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
                                                class="control" 
                                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.start_time') }}&quot;">
                                        </time-component>
                                    </td>
                                    <td>
                                        <time-component style="pull:right;">
                                            <input type="text" 
                                                :name="'timing[end_time]'" 
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
                                            :value="dayIndex"
                                            > 
                                    </td>
                                    <td style="margin-left:25px;">
                                        @{{ day.name }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="all_day_different_timing" v-if="stores.customDayDifferentTiming">
                            <table>
                                <tr style="background-color:#DED9D9;">
                                    <td colspan="2" 
                                        style="text-align:center; padding:15px;">
                                        {{ __('mpstorelocator::app.admin.days') }} </td>
                                    <td colspan="2" 
                                        style="text-align:center">{{ __('mpstorelocator::app.admin.timing') }} </td>
                                </tr>
                                <tr v-for="(day, dayIndex) in weekdaysArr">
                                    <td>
                                        <input type="checkbox" 
                                            :name="'timing['+dayIndex+']'"
                                            style="width:15px;height:16px; margin-right:25px;"
                                            class="booking_weekday"
                                            > 
                                    </td>
                                    <td style="margin-left:25px;">
                                        @{{ day.name }}
                                    </td>
                                    <td style="margin-left:25px;">
                                        <time-component style="pull:left;">
                                            <input type="text" 
                                                style="margin-left:20px;"
                                                :name="'timing['+dayIndex+'][start_time]'" 
                                                class="control" 
                                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.start_time') }}&quot;">
                                        </time-component>
                                    </td>
                                    <td style="margin-left:25px;">
                                        <time-component style="pull:left;">
                                            <input type="text" 
                                                :name="'timing['+dayIndex+'][end_time]'" 
                                                class="control" 
                                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.end_time') }}&quot;">
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
                    <div class="control-group" 
                        :class="[errors.has('store_holidays') ? 'has-error' : '']">
                        <label for="store_holidays" 
                            class="required">
                            {{ __('mpstorelocator::app.admin.store_holidays') }}</label>

                        <select name="store_holidays" 
                            class="control" 
                            multiple
                            name="stores_holidays[]"
                            id="store_holidays"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.store_holidays') }}&quot;">
                            @foreach ($holidays as $holiday)
                                <option value="{{ $holiday->id }}">{{ $holiday->name }}</option>
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
                            id="person_name" 
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
                            id="email" 
                            name="email" 
                            v-validate="'required'"
                            value="{{ old('email') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.email') }}&quot;">
                        <span class="control-error"
                            v-if="errors.has('email')">@{{ errors . first('email') }}</span>
                    </div>              
                    <div class="control-group" 
                        :class="[errors.has('mobile') ? 'has-error' : '']">
                        <label for="mobile"
                            class="required">{{ __('mpstorelocator::app.admin.mobile') }}</label>
                        <input type="number" 
                            class="control" 
                            name="mobile" 
                            v-validate="'required'"
                            value="{{ old('mobile') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.mobile') }}&quot;">
                        <span class="control-error"
                            v-if="errors.has('mobile')">@{{ errors . first('mobile') }}</span>
                    </div>              
                    <div class="control-group" 
                        :class="[errors.has('fax') ? 'has-error' : '']">
                        <label for="mobile"
                            class="required">{{ __('mpstorelocator::app.admin.fax') }}</label>
                        <input type="text" 
                            class="control" 
                            id="fax" 
                            name="fax" 
                            v-validate="'required'"
                            value="{{ old('fax') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.fax') }}&quot;">
                        <span class="control-error"
                            v-if="errors.has('fax')">@{{ errors . first('fax') }}</span>
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
                                id="country" 
                                @change="getState($event)" 
                                name="country">
                            <option value="0">{{ __('mpstorelocator::app.admin.select_country') }}</option>
                            @foreach (core()->countries() as $country)
                                <option value="{{ $country->code }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <span class="control-error" v-if="errors.has('country')">@{{ errors . first('country') }}</span>
                    </div>
                    
                    <div class="control-group" 
                    :class="[errors.has('state_province') ? 'has-error' : '']">
                        <label for="state_province" class="required">{{ __('mpstorelocator::app.admin.state_province') }}</label>
                        <select class="control" 
                            v-if="isState"  
                            v-validate="'required'" 
                            name="state_province">
                            <option  
                                v-for="(state, stateIndex) in statesArr" 
                                :value="state.default_name"
                                >@{{ state . default_name }}</option>

                        </select>
                        <input type="text" 
                            v-if="!isState"
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
                            name="city" 
                            v-validate="'required'"
                            value="{{ old('city') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.city') }}&quot;">
                        <span class="control-error" v-if="errors.has('city')">@{{ errors . first('city') }}</span>
                    </div>            
                    <div class="control-group" 
                        :class="[errors.has('street') ? 'has-error' : '']">
                        <label for="street" 
                            class="required">{{ __('mpstorelocator::app.admin.street') }}</label>
                        <input type="text" 
                            class="control" 
                            name="street" 
                            v-validate="'required'"
                            value="{{ old('street') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.street') }}&quot;">
                        <span class="control-error" v-if="errors.has('street')">@{{ errors . first('street') }}</span>
                    </div>            
                    <div class="control-group" 
                        :class="[errors.has('postal_code') ? 'has-error' : '']">
                        <label for="postal_code" 
                            class="required">{{ __('mpstorelocator::app.admin.postal_code') }}</label>
                        <input type="text" 
                            class="control" 
                            name="postal_code" 
                            v-validate="'required'"
                            value="{{ old('postal_code') }}"
                            data-vv-as="&quot;{{ __('mpstorelocator::app.admin.postal_code') }}&quot;">
                        <span class="control-error" v-if="errors.has('postal_code')">@{{ errors . first('postal_code') }}</span>
                    </div>               
                </div>
            </accordian>
        </div>
    </script>
    <script>
        Vue.component('store-time-div', {
            data: function() {
                return {
                    mannualForm:{
                        lat:(localStorage.getItem("admin_current_user_lat") != 'null') ? localStorage.getItem("admin_current_user_lat") : '',
                        long:(localStorage.getItem("admin_current_user_long") != 'null') ? localStorage.getItem("admin_current_user_long") : '',
                    },
                    stores: {
                        customDayDifferentTiming: false,
                        customDaySameTiming: false,
                    },
                    weekdaysArr: [{
                            'name': "{{ __('mpstorelocator::app.admin.sunday') }}",
                            'activeWeekDay': true,
                            'weekDaySlots': [{
                                'from': '',
                                'to': ''
                            }]
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.monday') }}",
                            'activeWeekDay': true,
                            'weekDaySlots': [{
                                'from': '',
                                'to': ''
                            }]
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.tuesday') }}",
                            'activeWeekDay': true,
                            'weekDaySlots': [{
                                'from': '',
                                'to': ''
                            }]
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.wednesday') }}",
                            'activeWeekDay': true,
                            'weekDaySlots': [{
                                'from': '',
                                'to': ''
                            }]
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.thursday') }}",
                            'activeWeekDay': true,
                            'weekDaySlots': [{
                                'from': '',
                                'to': ''
                            }]
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.friday') }}",
                            'activeWeekDay': true,
                            'weekDaySlots': [{
                                'from': '',
                                'to': ''
                            }]
                        },
                        {
                            'name': "{{ __('mpstorelocator::app.admin.saturday') }}",
                            'activeWeekDay': true,
                            'weekDaySlots': [{
                                'from': '',
                                'to': ''
                            }]
                        }
                    ],
                    isState: false,
                    statesArr: [],
                }
            },
            template: '#store-time-div-template',
            methods: {
                selectStoresOpens: function(event) {
                    if (event.target.value == 1) {
                        this.stores.customDayDifferentTiming = false;
                        this.stores.customDaySameTiming = false;
                    } else if (event.target.value == 2) {
                        this.stores.customDaySameTiming = true;
                        this.stores.customDayDifferentTiming = false;
                    } else if (event.target.value == 3) {
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
                getState: function(country) {
                    var this_this = this;
                    var country = country.target.value;
                    this_this = this;
                    this.$http.get("{{ route('admin.mpstorelocator.get-state') }}", {
                            params: {
                                query: country
                            }
                        })
                        .then(function(response) {
                            if (response.data.status == 200) {
                                this_this.isState = true;
                                this_this.statesArr = response.data.states_provience;
                            } else {
                                this_this.statesArr = [];
                                this_this.isState = false;
                            }
                        })
                        .catch(function(error) {
                            console.log(error)
                        })

                }

            },
        });
    </script>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
        function showPosition(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;

            localStorage.setItem('admin_current_user_lat', position.coords.latitude);
            localStorage.setItem('admin_current_user_long', position.coords.longitude);

            var alertElement = document.getElementById('alert-container');
            alertElement.style.display = 'block';
        }

        $(document).ready(function(){
            let adminCurrentLatitude = (localStorage.getItem("admin_current_user_lat") != 'null') ? localStorage.getItem("admin_current_user_lat") : '';
            
            let adminCurrentLongtitude = (localStorage.getItem("admin_current_user_long") != 'null') ? 
            localStorage.getItem("admin_current_user_long") : '';
            
            console.log(adminCurrentLatitude , adminCurrentLongtitude)

            $("#latitude").val(adminCurrentLatitude);
            $("#longitude").val(adminCurrentLongtitude);
        });
     
    </script>
@endpush
