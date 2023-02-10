@extends('adminlte::page')

@if ($isEdit)
    @section('title', __('pages.apply_leave.update'))
@else
    @section('title', __('pages.apply_leave.store'))
@endif

@section('content_header')
    <h3 class="m-0 text-dark"> {{ $isEdit ? __('pages.apply_leave.update') : __('pages.apply_leave.store') }}
    </h3>
@stop
@section('content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.apply-leaves.index') }}">{{ __('pages.apply_leave.title') }}</a>
        </li>
        <li class="breadcrumb-item active">
            {{ $isEdit ? __('pages.apply_leave.update') : __('pages.apply_leave.store') }}
        </li>
    </ol>
@stop

@section('content')
   @php 
   
   @endphp
    <div class="row" id="app-apply-leave">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="mb-1 mt-1">
                                {{ __('pages.apply_leave.title') }}</h5>
                        </div>

                        <div class="text-right col-sm-6">
                            <button type="button" @click="redirectToIndex"
                                class="btn btn-outline-danger btn-sm pl-4 pr-4">{{ __('pages.apply_leave.cand') }}</button>
                            <button type="button" class="btn btn-outline-success btn-sm pl-4 pr-4" @click="submitForm">
                                {{ $isEdit ? __('pages.apply_leave.update') : __('pages.apply_leave.store') }}
                            </button>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="store-container">
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">
                                {{ __('pages.apply_leave.full_phone') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="phone" class="form-control" id="phone" v-model="store.phone">
                                <span class="text-red small">@{{ errors.phone }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="position" class="col-sm-2 col-form-label">
                                {{ __('pages.apply_leave.position') }}
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
                            <label for="reason" class="col-sm-2 col-form-label">
                                {{ __('pages.apply_leave.reason') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8">
                                <textarea name="reason" v-model="store.reason" class="form-control" id="exampleFormControlTextarea1" rows="2">{{$isEdit ? $store->reason : ''}}</textarea>
                                <span class="text-red small">@{{ errors.reason }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">
                                {{ __('pages.apply_leave.start_date') }} - {{ __('pages.apply_leave.end_date') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-8 d-flex justify-content-between">
                                <div class='col-xs-3'>
                                    <div class="form-group">
                                        <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                        v-model="store.start_date">
                                        <span class="text-red small">@{{ errors.start_date }}</span>
                                    </div>
                                </div>
                                <div class='col-xs-3'>
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
        console.log('currentStore', currentStore);
        const indexUrl = "{{ route('admin.apply-leaves.index') }}";
        const createApplyLeaveUrl = "{{ route('admin.apply-leaves.store') }}";
        const updateApplyLeaveUrl = "{{ route('admin.apply-leaves.update', $store->id ?? ':id') }}";
    </script>
    <script type="module" src="{{ asset('/assets/admin/js/pages/apply-leave.js') }}"></script>
@stop
