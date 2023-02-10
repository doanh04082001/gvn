@extends('adminlte::page')

@php $isEdit = isset($customer) @endphp

@if($isEdit)
@section('title', __('pages.customers.edit_customer'))
@else
@section('title', __('pages.customers.create_customer'))
@endif

@section('content_header')
<h3 class="m-0 text-dark">{{ __('pages.customers.title_customer') }}</h3>
@stop
@section('content_breadcrumb')
<ul class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a
            href="{{ route('admin.customers.index') }}">{{ __('pages.customers.title_customer') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $isEdit ? __('pages.customers.edit_customer') : __('pages.customers.create_customer') }}</li>
</ul>
@stop

@section('content')
<div class="row" id="app-customer-form">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="mb-1 mt-1">{{ $isEdit ? __('pages.customers.edit_customer') : __('pages.customers.create_customer') }}</h5>
                    </div>
                    <div class="text-right col-sm-6">
                        <button type="button" @click="redirectToUrl(`{{ route('admin.customers.index') }}`)"
                                class="btn btn-outline-danger btn-sm pl-4 pr-4">{!! __('app.back_button_text') !!}</button>
                        <button type="button"
                                class="btn btn-outline-success btn-sm pl-4 pr-4"
                                @click="submitForm">
                            {!! __('app.save_button_text_icon') !!}
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" @keypress.enter.prevent class="mb-0" ref="customerFrm"
                    action="{{ $isEdit ? route('admin.customers.update', $customer->id) : route('admin.customers.store') }}">
                    @if ($isEdit)
                        @method('PUT')
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-md-6 pl-2 pr-2">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <input type="text" name="name" id="name" required
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $isEdit ? $customer->name : '') }}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @if ($isEdit)
                            <div class="form-group row">
                                <label for="code" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.code') }}
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <input type="text" name="code" id="code" class="form-control"
                                        value="{{ $isEdit ? $customer->code : '' }}" disabled>
                                </div>
                            </div>
                            @endif
                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.status') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <select name="status" id="status" required 
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        @foreach(__('pages.customers.status_option') as $key => $value)
                                            @if (old('status') == $key)
                                                <option value="{{ $key }}" selected>{{ $value }}</option>
                                            @else
                                                <option value="{{ $key }}" {{ $isEdit && ($key == $customer->status) ? 'selected' : ''}}>{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.email') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <input type="text" name="email" id="email" required 
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $isEdit ? $customer->email : '') }}" >
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.phone_number') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <input type="text" name="phone" id="phone" required 
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $isEdit ? $customer->phone : '') }}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birthday" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.birthday') }}
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <input type="date" name="birthday" id="birthday" 
                                        class="form-control @error('birthday') is-invalid @enderror"
                                        value="{{ old('birthday', $isEdit ? $customer->birthday : '') }}">
                                    @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.address') }}
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <input type="text" name="address" id="address" 
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address', $isEdit ? $customer->address : '') }}"
                                        >
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @if ($isEdit)
                            <div class="form-group row">
                                <label for="orders_count" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.order_count') }}
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <input type="text" name="orders_count" id="orders_count" 
                                        class="form-control" v-model="orderCount" disabled>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 pl-2 pr-2">
                            @if ($isEdit)
                            <div class="form-group row">
                                <label for="points" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.point') }}
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <input type="text" name="points" id="points"
                                        class="form-control" v-model="point" disabled>
                                </div>
                            </div>
                            @endif
                            <div class="form-group row">
                                <label for="note" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                    {{ __('pages.customers.note') }}
                                </label>
                                <div class="col-sm-9 col-lg-8 col-xl-9">
                                    <textarea id="note" rows="8" name="note" class="form-control 
                                        @error('note') is-invalid @enderror">{{ old('note', $isEdit ? $customer->note : '') }}</textarea>
                                    @error('note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    const POINT = {{ $isEdit ? $customer->points : 0 }};
    const ORDER_COUNT = {{ $isEdit ? $customer->orders_count : 0 }};
</script>

<script type="module" src="{{ asset('/assets/admin/js/pages/customer-form.js') }}"></script>
@stop
