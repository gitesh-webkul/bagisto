@extends('admin::layouts.content')

@section('page_title')
    {{ __('mpstorelocator::app.admin.stores') }}
@stop

@section('content')

    <div class="content full-page dashboard">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('mpstorelocator::app.admin.stores') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.mpstorelocator.stores.create') }}" class="btn btn-lg btn-primary">
                    {{ __('mpstorelocator::app.admin.create_new_stores') }}
                </a>
            </div>
        </div>

        <div class="page-content">
        </div>
    </div>

@stop