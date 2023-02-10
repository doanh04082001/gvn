@extends('adminlte::page')

@php $isEdit = isset($store) @endphp

@if ($isEdit)
    @section('title', __('pages.overtime.update'))
@else
    @section('title', __('pages.overtime.store'))
@endif

@section('content_header')
    <h3 class="m-0 text-dark"> {{ $isEdit ? __('pages.overtime.update') : __('pages.overtime.store') }}</h3>
@stop
@section('content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.overtime.index') }}">{{ __('pages.overtime.store') }}</a>
        </li>
        <li class="breadcrumb-item active">
            {{ $isEdit ? __('pages.overtime.update') : __('pages.overtime.store')}}
        </li>
    </ol>
@stop

@section('content')
    <div class="row" id="app-overtime">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="mb-1 mt-1">{{ __('pages.overtime.store') }}</h5>
                        </div>
                        <div class="text-right col-sm-6">
                            <button type="button" @click="redirectToIndex"
                                class="btn btn-outline-danger btn-sm pl-4 pr-4">{{ __('pages.apply_leave.cand') }}</button>
                            @if ($isEdit)
                                @if (Auth::user()->isSuperAdmin() || Auth::user()->id === $store->user_id)
                                    <button type="button" class="btn btn-outline-success btn-sm pl-4 pr-4"
                                        @click="submitForm">
                                        {{ $isEdit ? __('pages.overtime.update') : __('pages.overtime.store') }}
                                    </button>
                                @endif
                            @elseif ($isEdit == false)
                                <button type="button" class="btn btn-outline-success btn-sm pl-4 pr-4" @click="submitForm">
                                    {{ __('pages.overtime.store') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="store-container">
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">
                                {{ __('pages.overtime.full_phone') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="phone" class="form-control" id="phone"
                                    v-model="store.phone">
                                <span class="text-red small">@{{ errors.phone }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="position" class="col-sm-2 col-form-label">
                                {{ __('pages.overtime.position') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="possition" class="form-control" id="possition" value="{{Auth::user()->roles[0]->name}}" disabled>
                                @error('position')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="work_content" class="col-sm-2 col-form-label">
                                {{ __('pages.overtime.work_content') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <textarea name="work_content" class="form-control" id="exampleFormControlTextarea1" rows="2" v-model="store.work_content">{{$isEdit ? $store->work_content : ''}}</textarea>
                                <span class="text-red small">@{{ errors.work_content }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">
                                {{ __('pages.overtime.start_date') }} - {{ __('pages.overtime.end_date') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8 d-flex justify-content-between">
                                <div class='col-xs-4'>
                                    <div class="form-group">
                                        <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                            v-model="store.start_date">
                                        <span class="text-red small">@{{ errors.start_date }}</span>
                                    </div>
                                </div>
                                <div class='col-xs-4'>
                                    <div class="form-group">
                                        <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                            v-model="store.end_date">
                                        <span class="text-red small">@{{ errors.end_date }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        const currentStore = {!! $store ?? 'null' !!};
        const indexUrl = "{{ route('admin.overtime.index') }}";
        const createOverTime = "{{ route('admin.overtime.store') }}";
        const updateOverTime = "{{ route('admin.overtime.update', $store->id ?? ':id') }}";
    </script>
    <script type="module" src="{{ asset('/assets/admin/js/pages/overtime-form.js') }}"></script>
@stop
