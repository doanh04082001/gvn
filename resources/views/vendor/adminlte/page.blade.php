@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>

@section('body')
    <div class="wrapper">

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.top-navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        <div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}">

            {{-- Content Header --}}
            <div class="content-header">
                <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                @yield('content_header')
                            </div>
                            <div class="col-sm-6">
                                @yield('content_breadcrumb')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="content">
                <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                    @yield('content')
                </div>
            </div>

        </div>

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    <script>
        $(function () {
            $('#loader-wrapper').hide();
        });
    </script>
    @include('admin.components.script-constants')
    <script>
        moment.locale("{{ env('APP_LANG') }}");
        const TOTAL_UNREAD = {{ auth()->user()->totalUnreadNotifications() }};
        const GET_NOTIFICATION_URL = "{{ route('admin.notifications.index') }}";
        const MARK_AS_READ_URL = "{{ route('admin.notifications.mark-as-read', ':id') }}";
        const MARK_AS_READ_ALL_URL = "{{ route('admin.notifications.mark-as-read-all') }}";
    </script>
    <script type="module" src="{{ asset('assets/admin/firebase/utils/helper.js') }}"></script>
    @stack('js')
    @yield('js')
    <script type="module" src="{{ asset('assets/admin/js/pages/notifications.js') }}"></script>
    <script type="module" src="{{ asset('assets/admin/firebase/utils/fcm-initial.js') }}"></script>
@stop
