@extends('admin::layouts.content')

@section('page_title')
    {{ __('mpstorelocator::app.admin.assign_stores') }}
@stop

@section('content')

    <div class="content full-page dashboard">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('mpstorelocator::app.admin.assign_stores') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.mpstorelocator.stores.create') }}" class="btn btn-lg btn-primary">
                    {{ __('mpstorelocator::app.admin.save_assign_stores') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('fields', 'Webkul\MpStoreLocator\Datagrids\AssignStoresDataGrid')
            {!! $fields->render() !!}
        </div>
    </div>

@stop