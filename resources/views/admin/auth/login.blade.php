@extends('adminlte::auth.login')

@push('js')
    <script type="text/javascript" src="{{ asset('vendor/firebase8.6.1/firebase-app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/firebase8.6.1/firebase-messaging.js') }}"></script>
    <script type="module" src="{{ asset('assets/admin/js/pages/device-token.js') }}"></script>
@endpush
