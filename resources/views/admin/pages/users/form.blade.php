@extends('adminlte::page')

@php
    use App\Models\User;
    use App\Models\Role;
    $isEdit = isset($user);
@endphp

@if ($isEdit)
    @section('title', __('pages.users.edit_user'))
@else
    @section('title', __('pages.users.create_user'))
@endif

@section('content_header')
    <h3 class="m-0 text-dark">{{ __('pages.users.title_user') }}</h3>
@stop

@section('content_breadcrumb')
    <ul class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">{{ __('pages.users.title_user') }}</a>
        </li>
        <li class="breadcrumb-item active">
            {{ $isEdit ? __('pages.users.edit_user') : __('pages.users.create_user') }}
        </li>
    </ul>
@stop

@section('content')
    <div class="row" id="app-user-form">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="mb-1 mt-1">
                                {{ $isEdit ? __('pages.users.edit_user') : __('pages.users.create_user') }}
                            </h5>
                        </div>
                        <div class="text-right col-sm-6">
                            <button type="button" @click="redirectToUrl(`{{ route('admin.users.index') }}`)"
                                class="btn btn-outline-danger btn-sm pl-4 pr-4">{!! __('app.back_button_text') !!}</button>
                            <button type="button" class="btn btn-outline-success btn-sm pl-4 pr-4" @click="submitForm">
                                {!! __('app.save_button_text_icon') !!}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" @keypress.enter.prevent class="mb-0" ref="userFrm"
                        action="{{ $isEdit ? route('admin.users.update', $user->id) : route('admin.users.store') }}">
                        @if ($isEdit)
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-6 pl-2 pr-2">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.email') }}
                                        @if (!$isEdit)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <input type="text" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $isEdit ? $user->email : '') }}"
                                            {{ $isEdit ? 'disabled' : 'required' }}>
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.password') }}
                                        @if (!$isEdit)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <input type="password" name="password" id="password" required
                                            class="form-control @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.password_confirmation') }}
                                        @if (!$isEdit)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            required
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            value="{{ old('password_confirmation') }}">
                                        @error('password_confirmation')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="user_role" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.position') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <select name="user_role" id="user_role" required
                                            class="form-control @error('user_role') is-invalid @enderror">
                                            <option value="">{{ __('pages.users.select_position') }}</option>
                                            @foreach ($roles as $role)
                                                @if ($role->name !== Role::SUPER_ADMIN_NAME)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('user_role') === $role->id
                                                            ? 'selected'
                                                            : ($isEdit && !empty($user->roles->first()) && $user->roles->first()->id === $role->id
                                                                ? 'selected'
                                                                : '') }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('user_role')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="team" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.team') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <select class="select2-multiple-team" name="team[]" id="team" required multiple="multiple"
                                            id="select2Multiple">
                                            @foreach ($teams as $team )
                                                <option {{ $isEdit ? ($user->teams->contains('id',$team->id) ? 'selected' : ''):'' }}
                                                    value="{{$team->id}}" > {{$team->name}}
                                                </option>   
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pl-2 pr-2">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.full_name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <input type="text" name="name" id="name" required
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $isEdit ? $user->name : '') }}">
                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.phone') }}
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <input type="text" name="phone" id="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $isEdit ? $user->phone : '') }}">
                                        @error('phone')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="birthday" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.birthday') }}
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <input type="date" name="birthday" id="birthday"
                                            class="form-control @error('birthday') is-invalid @enderror"
                                            value="{{ old('birthday', $isEdit ? $user->birthday : '') }}">
                                        @error('birthday')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 col-lg-4 col-xl-3 col-form-label">
                                        {{ __('pages.users.address') }}
                                    </label>
                                    <div class="col-sm-9 col-lg-8 col-xl-9">
                                        <input type="text" name="address" id="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', $isEdit ? $user->address : '') }}">
                                        @error('address')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
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

@section('css')
    <link rel="stylesheet" href="{{ asset('/vendor/vue-select/vue-select.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    /* .select2 .select2-container  */
    .select2-container--default{
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            padding: 3px 0px;
            height: 30px;
        }

        .select2-container {
            margin-top: -5px;
        }

        option {
            white-space: nowrap;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 0px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #216992;
        }

        .select2-container--default .select2-selection--multiple {
            margin-top: 10px;
            border-radius: 5px;
        }

        .select2-container--default .select2-results__group {
            background-color: #eeeeee;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2-multiple-team').select2({
                placeholder: "Chọn team",
                allowClear: true
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="path/to/select2.min.js"></script>
    <script src="{{ asset('/vendor/vue-select/vue-select.js') }}"></script>
    <script type="module" src="{{ asset('/assets/admin/js/pages/user-form.js') }}"></script>
@stop
