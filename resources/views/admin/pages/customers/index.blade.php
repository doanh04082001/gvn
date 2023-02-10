@extends('adminlte::page')

@section('title', __('pages.customers.list_customer'))

@section('content_header')
<h3 class="m-0 text-dark">{{ __('pages.customers.list_customer') }}</h3>
@stop
@section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.customers.index') }}">{{ __('pages.customers.title_customer') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('pages.customers.list_customer') }}</li>
</ol>
@stop

@section('content')
<div class="row" id="app-customer-list">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h5 class="mb-1 mt-1">{{ __('pages.customers.list_customer') }}</h5>
                    </div>
                    @can('customers.create')
                    <div class="col-6 text-right">
                        <button class="btn btn-sm btn-outline-success"
                            @click="redirectToUrl(`{{ route('admin.customers.create') }}`)">
                            <i class="fas fa-fw fa-plus"></i>
                            {{ __('pages.customers.create_customer') }}
                        </button>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="customer-table" class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('pages.customers.name') }}</th>
                            <th>{{ __('pages.customers.code') }}</th>
                            <th>{{ __('pages.customers.phone_number') }}</th>
                            <th>{{ __('pages.customers.point') }}</th>
                            <th>{{ __('pages.customers.order_count') }}</th>
                            <th>{{ __('pages.customers.status') }}</th>
                            <th>{{ __('app.action') }}</th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm" /></th>
                            <th><input type="text" class="form-control form-control-sm" /></th>
                            <th><input type="text" class="form-control form-control-sm" /></th>
                            <th>
                                <div class="container">
                                    <div class="row">
                                        <input v-model="minPointDisplay" type="text"
                                            class="form-control form-control-sm col-sm-5" maxlength="15"/>
                                        <span class="col-sm-2 d-inline-block text-center mt-1">~</span>
                                        <input v-model="maxPointDisplay" type="text"
                                            class="form-control form-control-sm col-sm-5" maxlength="15"/>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <div class="container">
                                    <div class="row">
                                        <input v-model="minOrderDisplay" type="text"
                                            class="form-control form-control-sm col-sm-5" maxlength="15"/>
                                        <span class="col-sm-2 d-inline-block text-center mt-1">~</span>
                                        <input v-model="maxOrderDisplay" type="text"
                                            class="form-control form-control-sm col-sm-5" maxlength="15"/>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <select class="form-control form-control-sm">
                                    <option value="">{{ __('app.show_all_text') }}</option>
                                    @foreach(__('pages.customers.status_option') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    const message = `{!! session()->get('success') ?? null !!}`;
    const CUSTOMER_ROUTES = {
        getDatatable: "{{ route('admin.customers.getDatatable') }}",
        edit: "{{ route('admin.customers.edit', ['customer' => ':id']) }}",
        update: "{{ route('admin.customers.update', ['customer' => ':id']) }}",
        delete: "{{ route('admin.customers.destroy', ['customer' => ':id']) }}",
    };
    const CUSTOMER_PERMISSIONS = {
        edit: @can('customers.edit') true @else false @endcan,
        delete: @can('customers.delete') true @else false @endcan
    };
</script>
<script type="module" src="{{ asset('/assets/admin/js/pages/customer.js') }}"></script>
@stop
