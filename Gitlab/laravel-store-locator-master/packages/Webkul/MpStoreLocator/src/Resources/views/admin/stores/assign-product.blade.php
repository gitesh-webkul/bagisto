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
                    <button type="button" id="submitQuotationProductForm" class="btn btn-lg btn-primary">
                        {{ __('mpstorelocator::app.admin.assign_product') }}
                    </button>
                </div>
             
            </div>

            <div class="page-content">
                <div class="alert-wrapper" id="success" style="display: none;">
                    <div class="alert alert-success">
                       <span class="icon white-cross-sm-icon"></span>
                       <p>{{ __('mpstorelocator::app.admin.msg.product_assign_successfully') }}</p>
                     </div>
                 </div>
                <div class="alert-wrapper" id="failure" style="display: none;">
                    <div class="alert alert-error">
                       <span class="icon white-cross-sm-icon"></span>
                       <p>{{ __('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again') }}</p>
                     </div>
                </div>
                <input type="hidden"
                        value="{{ $storesDetail->id }}" 
                        name="stores_id" 
                        id="stores_id" />

                @inject('fields', 'Webkul\MpStoreLocator\Datagrids\StoresProductsDataGrid')
                {!! $fields->render() !!}
            </div>

            <store-time-div></store-time-div>

        </form>
    </div>
@stop
@push('scripts')
    
    <script>
        $(document).ready(function(e) {

            $(document).on('click', '#submitQuotationProductForm', function(e) {
                var quotationUrl = "{{route('admin.mpstorelocator.stores.edit',['__stores_id__'])}}";
                //console.log(quotationUrl);
                $("#success, #failure").hide();
                var storesId = $("#stores_id").val();
                var productIdArr = [];
                var submitBtn = $("#submitQuotationProductForm");
                //submitBtn.attr('disabled',true);

                $( "table tbody tr" ).each(function( index ) {
                    if( $(this).find('.productCheckBox').is(':checked') ){
                        let  productId = $(this).find('.productCheckBox').val();
                        let  cost_price = $(this).find('.cost_price').val();
                        let  quantity = $(this).find('.quantity').val();
                        productIdArr.push({
                                            'productId':productId,
                                            'cost_price':cost_price, 
                                            'quantity':quantity
                                        });
                    }
                });
                e.preventDefault();
                $.ajax({
                    url: "{{ route('admin.mpstorelocator.stores.assign-products') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: {'products':productIdArr , 'stores_id':storesId},
                    dataType: 'json',
                    success: function(data) {
                        //submitBtn.attr('disabled',false);
                        if(data.status == 200){
                            quotationUrl = quotationUrl.replace('__stores_id__', storesId);
                            $("#success").show();
                            setTimeout(function(){ window.location.href = quotationUrl }, 1000);
                        }else{
                            $("#failure").find('p').text(data.msg)
                            $("#failure").show();
                        }
                    }
                });
            });

            //select all 
            $(document).on('change', '#select_all', function() {
                if ($(this).is(":checked")) {
                    $('.productCheckBox').prop('checked', true);
                } else {
                    $('.productCheckBox').prop('checked', false);
                }
            });
        
        });
    </script>
@endpush

