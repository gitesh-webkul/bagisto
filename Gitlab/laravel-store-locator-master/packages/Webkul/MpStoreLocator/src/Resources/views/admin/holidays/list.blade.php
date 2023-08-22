@extends('admin::layouts.content')

@section('page_title')
    {{ __('mpstorelocator::app.admin.holidays') }}
@stop

@section('content')

    <div class="content full-page dashboard">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('mpstorelocator::app.admin.holidays') }}</h1>
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>
                    <span >
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>
                <a href="{{ route('admin.mpstorelocator.manage-holidays.create') }}" class="btn btn-lg btn-primary">
                    {{ __('mpstorelocator::app.admin.add_new_holidays') }}
                </a>
            </div>
        </div>
        <div class="page-content">
            @inject('fields', 'Webkul\MpStoreLocator\Datagrids\StoreHolidaysDataGrid')
            {!! $fields->render() !!}

        </div>
    </div>
    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>
        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>

@stop
@push('scripts')
    @include('admin::export.export', ['gridName' => $fields])
@endpush