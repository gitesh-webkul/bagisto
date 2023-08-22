@extends('admin::layouts.content')
@section('page_title')
    {{ __('mpstorelocator::app.admin.edit_holidays') }}
@stop
@push('css')
@endpush
@section('content')
    <div class="content full-page dashboard">
        <form method="POST" 
            action="{{ route('admin.mpstorelocator.manage-holidays.update' ,[$holiday->id]) }}" @submit.prevent="onSubmit">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link"
                            onclick="window.location = '{{ route('admin.mpstorelocator.index') }}'"></i>
                        {{ __('mpstorelocator::app.admin.edit_holidays') }}
                    </h1>
                </div>
                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('mpstorelocator::app.admin.save_stores') }}
                    </button>
                </div>
            </div>
            <holiday-div></holiday-div>
           
        </form>
    </div>
@stop
@push('scripts')

    <script type="text/x-template" id="store-time-div-template">
        <div>
            <div class="page-content">
                <div class="form-container">
                    @csrf()
                    <div slot="body">         
                        <div class="control-group" :class="[errors.has('attribute_label') ? 'has-error' : '']">
                            <label for="attribute_label" class="required">
                                {{ __('mpstorelocator::app.admin.enabled') }}</label>
                            <select 
                                v-model="holiday.status"
                                name="status" 
                                class="control" 
                                id="enabled"
                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.enabled') }}&quot;">
                                <option value="A">{{ __('mpstorelocator::app.admin.enabled') }}
                                </option>
                                <option value="D">{{ __('mpstorelocator::app.admin.disabled') }}
                                </option>
                            </select>
                        </div>
                        <div class="control-group" 
                            :class="[errors.has('holiday_name') ? 'has-error' : '']">
                            <label for="holiday_name"
                                class="required">{{ __('mpstorelocator::app.admin.holiday_name') }}</label>
                            <input type="text" 
                                class="control" 
                                name="holiday_name" 
                                v-validate="'required'"
                                v-model="holiday.name"
                                value="{{ old('holiday_name') }}"
                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.holiday_name') }}&quot;">
                            <span class="control-error" v-if="errors.has('holiday_name')">@{{ errors . first('holiday_name') }}</span>
                        </div>
                        <div class="control-group" 
                            :class="[errors.has('date_type') ? 'has-error' : '']">
                            <label for="date_type" class="required">
                                {{ __('mpstorelocator::app.admin.date_type') }}</label>
                            <select name="date_type" 
                                    v-model="holiday.date_type"
                                    class="control"
                                    @change="changeDateDiv($event)"
                                data-vv-as="&quot;{{ __('mpstorelocator::app.admin.date_type') }}&quot;">
                                <option value="1">{{ __('mpstorelocator::app.admin.single_day') }}
                                </option>
                                <option value="2">{{ __('mpstorelocator::app.admin.date_range') }}
                                </option>
                            </select>
                            <span class="control-error"
                            v-if="errors.has('date_type')">@{{ errors.first('date_type') }}</span>
                        </div>
                        <div class="date_div_section">
                            <div class="control-group" 
                                :class="[errors.has('holiday_date') ? 'has-error' : '']"
                                v-if="holiday.dateDiv">
                                <label for="holiday_date" class="required">
                                    {{ __('mpstorelocator::app.admin.holiday_date') }}</label>
                                <date>
                                    <input 
                                        autocomplete="off"
                                        v-model="holiday.holiday_date"
                                        type="text" 
                                        name="holiday_date" 
                                        class="control" 
                                        v-validate="'required'"
                                        value="{{ old('holiday_date') }}" 
                                        data-vv-as="&quot; {{ __('mpstorelocator::app.admin.holiday_date') }}&quot;"/>
                                </date>
                                <span class="control-error" v-if="errors.has('holiday_date')">@{{ errors.first('holiday_date') }}</span>
                            </div>
                            <div  v-else>
                                <div class="control-group" 
                                    :class="[errors.has('holiday_date_from') ? 'has-error' : '']">
                                    <label for="holiday_date_from" class="required">
                                        {{ __('mpstorelocator::app.admin.holiday_date_from') }}</label>
                                    <date>
                                        <input 
                                            autocomplete="off"
                                            type="text" 
                                            v-model="holiday.holiday_date"
                                            name="holiday_date_from" 
                                            class="control" 
                                            v-validate="'required'" 
                                            value="{{ old('holiday_date_from') }}" 
                                            data-vv-as="&quot; {{ __('mpstorelocator::app.admin.holiday_date_from') }}&quot;"/>
                                    </date>
                                    <span class="control-error"
                                    v-if="errors.has('holiday_date_from')">@{{ errors.first('holiday_date_from') }}</span>
                                </div>
                                <div class="control-group" 
                                    :class="[errors.has('holiday_date_to') ? 'has-error' : '']">
                                    <label for="holiday_date_to" class="required">
                                        {{ __('mpstorelocator::app.admin.holiday_date_to') }}</label>
                                    <date>
                                        <input 
                                            autocomplete="off"
                                            type="text" 
                                            v-model="holiday.holiday_date_to"
                                            name="holiday_date_to" 
                                            class="control" 
                                            v-validate="'required'" 
                                            value="{{ old('holiday_date_to') }}" 
                                            data-vv-as="&quot; {{ __('mpstorelocator::app.admin.holiday_date_to') }}&quot;"/>
                                    </date>
                                    <span class="control-error"
                                    v-if="errors.has('holiday_date_to')">@{{ errors.first('holiday_date_to') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
        </script>
    <script>
        Vue.component('holiday-div', {
            inject: ['$validator'],
            data: function() {
                return {
                    holiday:{
                        status:"{{$holiday->status}}",
                        name:"{{$holiday->name}}",
                        date_type:"{{$holiday->date_type}}",
                        holiday_date:"{{$holiday->date_from}}",
                        holiday_date_to:"{{$holiday->date_to}}",
                        dateDiv: true,
                        dateRangeDiv: false,
                    },
                    

                }
            },
            template: '#store-time-div-template',
            methods: {
                changeDateDiv: function(event) {
                    if (event.target.value == 1) {
                        this.holiday.dateDiv = true;
                        this.holiday.dateRangeDiv = false;
                    } else if (event.target.value == 2) {
                        this.holiday.dateDiv = false;
                        this.holiday.dateRangeDiv = true;
                    } 
                },
            },
            created(){
                let datetype = "{{$holiday->date_type}}";
                console.log(datetype);
                if (datetype == 1) {
                        this.holiday.dateDiv = true;
                        this.holiday.dateRangeDiv = false;
                    } else if (datetype == 2) {
                        this.holiday.dateDiv = false;
                        this.holiday.dateRangeDiv = true;
                    } 
            },
        });
    </script>

@endpush

