@extends('adminlte::page')

@section('title', __('pages.users.title_user'))

@section('content_header')
    <h4 class="m-0 text-dark">{{ __('pages.users.title_user') }}</h4>
@stop

@section('content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">{{ __('pages.users.title_user') }}</a>
        </li>
    </ol>
@stop

@section('content')
    <div id="app-user">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mb-1 mt-1">{{ __('pages.users.title_list') }}</h5>
                            </div>
                            {{-- @can('users.create')
                                <div class="col-6 text-right">
                                    <button class="btn btn-sm btn-outline-success"
                                        @click="redirectToUrl(`{{ route('admin.users.create') }}`)">
                                        <i class="fas fa-plus"></i>
                                        {{ __('pages.users.create_user') }}</button>
                                </div>
                            @endcan --}}
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="user-table" class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('pages.users.name_login') }}</th>
                                    <th>{{ __('pages.users.email') }}</th>
                                    <th>{{ __('pages.users.full_name') }}</th>
                                    <th>{{ __('pages.users.position') }}</th>
                                    <th>{{ __('app.action') }}</th>
                                </tr>
                                <tr>
                                    <th><input type="text" class="form-control form-control-sm" /></th>
                                    <th><input type="text" class="form-control form-control-sm" /></th>
                                    <th><input type="text" class="form-control form-control-sm" /></th>
                                    <th>
                                        <select class="form-control form-control-sm">
                                            <option value="">{{ __('app.show_all_text') }}</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
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
    </div>

@stop
@section('css')
@stop
@section('js')
    <script>
        const message = `{!! session()->get('success') ?? null !!}`;
        const SUPER_ADMIN_TEXT = `{{ __('app.super_admin') }}`
        const EDIT_USER_BUTTON_TEXT = `{{ __('app.save_button_text') }}`
        const CAN_EDIT_USER =
            @can('users.edit')
                true
            @else
                false
            @endcan ;
        const CAN_DELETE_USER =
            @can('users.delete')
                true
            @else
                false
            @endcan ;
    </script>
    <script type="module" src="{{ asset('assets/admin/js/pages/user.js') }}"></script>
@stop
