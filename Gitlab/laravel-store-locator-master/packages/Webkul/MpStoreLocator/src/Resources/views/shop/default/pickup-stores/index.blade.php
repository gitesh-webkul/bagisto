@extends('shop::layouts.master')
@section('page_title')
    {{ __('mpstorelocator::app.shop.pickup_stores') }}
@endsection
@section('head')
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-OzzGEfpfo3m6WdkFztHEKzGMOc3s_h8&callback=initAutocomplete&libraries=places&v=weekly" async
    ></script>
@stop
@push('css')
    
<style>
#map {
  height: 100%;
}
</style>
@endpush
@section('content-wrapper')
    <div class="auth-content form-container">
        <div class="container">
            <div class="col-lg-10 col-md-12 offset-lg-1">
                <div class="heading">
                    <h2 class="fs24 fw6">
                        {{ __('mpstorelocator::app.shop.pickup_stores') }}
                    </h2>
                </div>
                <div class="body col-12">
                    @if(core()->getConfigData('sales.carriers.pickup_store.show_pickup_stores_page') == "Y")
                        <h3 class="fw6">
                            {{ __('mpstorelocator::app.shop.your_location')}}
                        </h3>
                        <p class="fs16">
                            {{ __('mpstorelocator::app.shop.your_location_info')}}
                        </p>
                        <location-form-component></location-form-component>
                    @else
                    <h3 class="fw6">
                        {{ __('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again')}}
                    </h3>
                    @endif
                </div>
                <div class="body col-12">
                    <h2>{{ __('mpstorelocator::app.shop.map') }}</h2>
                    <div id="map" style = "width:580px; height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/x-template" id="location-form-component-template">
        <div>
            <div id="alert-container" 
                class="showSuccessAlert"  
                style="display:none;">
                <div class="alert alert-success alert-dismissible" id="564">
                    <a href="#" 
                        class="close" 
                        data-dismiss="alert" 
                        aria-label="close">×</a>
                        <strong>{{ __('mpstorelocator::app.shop.success') }}! </strong>
                        {{ __('mpstorelocator::app.shop.location_update_successfully') }}
                </div>
            </div>
            <input type="radio" 
                id="mannual_set_location" 
                name="set_location" 
                checked
                @click="showLocationSection($event)" 
                value="mannual" />
            <label for="mannual_set_location"> {{ __('mpstorelocator::app.shop.manual_location') }}</label><br><hr />
                <div v-if="mannualSection" 
                    id="mannual-add-location-block" 
                    style="margin-lechecked">
                    <form
                        action="#"
                        @submit.prevent="latLongSubmit()">
                        {{ csrf_field() }}

                        <div class="control-group mt-4" :class="[errors.has('password') ? 'has-error' : '']">
                            <label for="password" class="required label-style">
                                {{ __('mpstorelocator::app.shop.latitude') }}
                            </label>
                            <input
                                type="text"
                                name="latitude"
                                id="latitude"
                                class="form-style"
                                v-model="mannualForm.lat"
                                v-validate="'required'"
                                data-vv-as="&quot;{{ __('mpstorelocator::app.shop.latitude') }}&quot;" />
                            <span class="control-error" 
                                v-if="errors.has('latitude')" 
                                v-text="errors.first('latitude')"></span>
                        </div>
                        <div class="control-group mt-4" :class="[errors.has('password') ? 'has-error' : '']">
                            <label for="password" class="required label-style">
                                {{ __('mpstorelocator::app.shop.longitude') }}
                            </label>
                            <input
                                type="text"
                                class="form-style"
                                id="longitude"
                                name="longitude"
                                v-model="mannualForm.long"
                                v-validate="'required'"
                                value="{{ old('longitude') }}"
                                data-vv-as="&quot;{{ __('mpstorelocator::app.shop.longitude') }}&quot;" />

                            <span class="control-error" 
                                v-if="errors.has('longitude')" 
                                v-text="errors.first('longitude')"></span>
                        </div>
                        <div style="text-align:center;">
                            <button class="theme-btn mt-4" type="submit">
                                {{ __('mpstorelocator::app.shop.set_lat_long_as_your_current_location') }}
                               
                            </button>
                            <button class="theme-btn mt-4" 
                                onclick="getLocation()" 
                                type="button">
                                {{ __('mpstorelocator::app.shop.automatically_find_set_your_location') }}
                            </button>
                        </div>
                    </form>
                </div>

            <input type="radio" 
                class="mt-4"  
                id="address_search_set_location" 
                name="set_location"
                @click="showLocationSection($event)" 
                value="address_search" />
            <label for="address_search_set_location"> {{ __('mpstorelocator::app.shop.address_search') }}</label><br><hr />
                <div v-if="addressSearchSection"id="address-search-location" style="margin-left:10px;">
                    <div class="control-group">
                        <label for="first_name" class="required label-style">
                            {{ __('mpstorelocator::app.shop.your_location_is') }}
                        </label>
                        <input
                            type="text"
                            id="searchTextField"
                            class="form-style"
                            name="searchTextField"
                            v-validate="'required'" />
                        <span class="control-error"></span>
                    </div>     
                </div>
        </div>
    </script>

<script>
$(document).ready(function(e){
    //alert("working")
    initMap();
});


function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function initMap() {
    console.log('Init')
  const myLatLng = { lat: -25.363, lng: 131.044 };
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: myLatLng,
  });

  new google.maps.Marker({
    position: myLatLng,
    map,
    title: "Hello World!",
  });
}

function showPosition(position) {
    document.getElementById("latitude").value = position.coords.latitude;
    document.getElementById("longitude").value = position.coords.longitude;

    localStorage.setItem('current_user_lat',position.coords.latitude);
    localStorage.setItem('current_user_long', position.coords.longitude);
    
    var alertElement = document.getElementById('alert-container');
    alertElement.style.display = 'block';

    setTimeout(function(){ 
        alertElement.style.display = 'none';
    }, 
    1000);
}

let autocomplete;
let address1Field;
let address2Field;
let postalField;
function initAutocomplete() {
  address1Field = document.querySelector("#searchTextField");
  address2Field = document.querySelector("#address2");
  postalField = document.querySelector("#postcode");
  // Create the autocomplete object, restricting the search predictions to
  // addresses in the US and Canada.
  autocomplete = new google.maps.places.Autocomplete(address1Field, {
    componentRestrictions: { country: ["us", "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
  });
  address1Field.focus();
  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener("place_changed", fillInAddress);
}
function fillInAddress() {
  // Get the place details from the autocomplete object.
  const place = autocomplete.getPlace();
  console.log(place)
  let address1 = "";
  let postcode = "";

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  // place.address_components are google.maps.GeocoderAddressComponent objects
  // which are documented at http://goo.gle/3l5i5Mr
  for (const component of place.address_components) {
      console.log("working")
    const componentType = component.types[0];
    var latitude = componentType.geometry.location.lat();
                    var longitude = componentType.geometry.location.lng();
    console.log(latitude)
    console.log(longitude)

    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.short_name;
        break;
      }

      case "postal_code": {
        postcode = `${component.long_name}${postcode}`;
        break;
      }

      case "postal_code_suffix": {
        postcode = `${postcode}-${component.long_name}`;
        break;
      }
      case "locality":
        document.querySelector("#locality").value = component.long_name;
        break;
      case "administrative_area_level_1": {
        document.querySelector("#state").value = component.short_name;
        break;
      }
      case "country":
        document.querySelector("#country").value = component.long_name;
        break;
    }
  }

  //address1Field.value = address1;
  postalField.value = postcode;
  // After filling the form with address components from the Autocomplete
  // prediction, set cursor focus on the second address line to encourage
  // entry of subpremise information such as apartment, unit, or floor number.
  address2Field.focus();
}

/* const input = document.getElementById("searchTextField");

const options = {
  componentRestrictions: { country: "us" },
  fields: ["address_components", "geometry", "icon", "name"],
  strictBounds: false,
  types: ["establishment"],
};

const autocomplete = new google.maps.places.Autocomplete(input, options); */
</script>
    <script>
        Vue.component('location-form-component', {
            template: '#location-form-component-template',
            data: function () {
                return {
                    mannualForm:{
                        lat:(localStorage.getItem("current_user_lat") != 'null') ? localStorage.getItem("current_user_lat") : '',
                        long:(localStorage.getItem("current_user_long") != 'null') ? localStorage.getItem("current_user_long") : '',
                    },
                    mannualSection:true,
                    addressSearchSection:true
                }
            },

            methods: {
                latLongSubmit:function(){
                    localStorage.setItem('current_user_lat',this.mannualForm.lat);
                    localStorage.setItem('current_user_long', this.mannualForm.long);
                    
                    var alertElement = document.getElementById('alert-container');
                    alertElement.style.display = 'block';
                    setTimeout(function(){ 
                        alertElement.style.display = 'none';
                     }, 
                    1000);                   
                },
                showLocationSection:function(event){
                    let showSectionValue = event.target.value;
                    if(showSectionValue == "mannual"){
                        this.mannualSection = true;
                        this.addressSearchSection = false;
                    }else{
                        this.mannualSection = false;
                        this.addressSearchSection = true;
                    }
                }
            },
            /* mounted() {
                new google.maps.places.Autocomplete(
                    this.$refs["autocomplete"]
                );
            }, */
        })
    </script>
@endpush
