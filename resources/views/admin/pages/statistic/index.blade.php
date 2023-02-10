@extends('adminlte::page')

@section('title', Thống kê)

@section('content_header')
    <h3 class="m-0 text-dark"> {{ __('pages.apply_leave.title') }}</h3>
@stop
@section('content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.apply-leaves.index') }}">{{ __('pages.apply_leave.title') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('pages.apply_leave.list_apply') }}</li>
    </ol>
@stop

@section('content')
    <h1>thống kê</h1>

  
@stop

@section('js')
    <script>

    </script>

@stop
