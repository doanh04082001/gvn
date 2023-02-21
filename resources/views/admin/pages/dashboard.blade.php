@php
    use App\Models\Notification;
@endphp

@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content_header')
    <h1 class="m-0 text-dark">{{ __('pages.statistic') }}</h1>
@stop

@section('content')
@php                
@endphp

<div class="row" id="app-dashboard">
    <style>
        .row .float-right{
            margin-right: 0px;
        }
        .paginationjs-pages ul{
            padding-left: 10px
        }
        .paginationjs-page {
            margin-right: 2px;
            display: inline-block;
            border: 1px solid #007bff;
            background-color: #007bff;
            border-radius: 5px
        }
        .paginationjs-page a {
            color: #fff !important;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
        }
    </style>
    <div class="col-12">
        <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 mb-3">
                            <select class="form-control form-control-sm select" id="user-select">
                                <option value="">{{ __('pages.dashboard.all_user') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 mb-3">
                            <select class="form-control form-control-sm select" id="role-select">
                                <option value="">{{ __('pages.dashboard.all_roles') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="app-apply-leave">
                        <h4>{{ __('pages.dashboard.apple_leave') }}</h4>
                        <div class="table-responsive-md">
                            <table id="apply-leave-table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('pages.dashboard.name') }}</th>
                                    <th>{{ __('pages.dashboard.sdt') }}</th>
                                    <th>{{ __('pages.dashboard.address') }}</th>
                                    <th>{{ __('pages.dashboard.start_date') }}</th>
                                    <th>{{ __('pages.dashboard.end_date') }}</th>
                                    <th>{{ __('pages.dashboard.total') }}</th>
                                </tr>
                                </thead>
                                <tbody id="apply-leave-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row float-right">
                        <div id="pagination-container"></div>
                    </div>

                    {{-- overtime --}}
                    <div id="app-apply-leave">
                        <h4>{{ __('pages.dashboard.overtime') }}</h4>
                        <div class="table-responsive-md">
                            <table id="apply-leave-table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('pages.dashboard.name') }}</th>
                                    <th>{{ __('pages.dashboard.sdt') }}</th>
                                    <th>{{ __('pages.dashboard.address') }}</th>
                                    <th>{{ __('pages.dashboard.start_date') }}</th>
                                    <th>{{ __('pages.dashboard.end_date') }}</th>
                                    <th>{{ __('pages.dashboard.total') }}</th>
                                </tr>
                                </thead>
                                <tbody id="overtime-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row float-right">
                        <div id="pagination-overtime-container"></div>
                    </div>
                </div>
        </div>
    </div>
   
</div>
@stop
@section('js')
    <script>
        const router = '{{route('admin.get.apply_leave.datatable')}}'
        const routerOvertime = '{{route('admin.get.overtime.datatable')}}'
    </script>
    <script type="module" src="{{ asset('assets/admin/js/pages/dashboard/apply-leave.js') }}"></script>
    <script type="module" src="{{ asset('assets/admin/js/pages/dashboard/overtime.js') }}"></script>
@endsection
