@php
    use App\Models\Notification;
@endphp

@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
@php            
@endphp

<div class="row" id="app-dashboard">
    <div class="col-12">
        <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 mb-3">
                            <select class="form-control form-control-sm" id="user-select">
                                <option value="">{{ __('pages.dashboard.all_user') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                </div>
        </div>
    </div>
</div>
@stop
@section('js')
    <script>
        const router = '{{route('admin.get.apply_leave.datatable')}}'
    </script>
    <script type="module" src="{{ asset('assets/admin/js/pages/dashboard/pending-order.js') }}"></script>

    <script>
// Import the library
import Pagination from 'pagination.js';

// Sample data array
const data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

// Initialize the Pagination library
const pagination = new Pagination({
  data,
  perPage: 3,
  page: 1,
});

// Get the current page of data
const currentPage = pagination.getPageData();

// Render the data to the page
currentPage.forEach(item => {
  document.getElementById('data-list').innerHTML += `<li>${item}</li>`;
});

// Render the pagination buttons
document.getElementById('pagination-buttons').innerHTML = pagination.render();

// Listen for pagination button clicks
document.getElementById('pagination-buttons').addEventListener('click', e => {
  if (e.target.tagName === 'A') {
    pagination.goToPage(e.target.dataset.page);
    document.getElementById('data-list').innerHTML = '';
    pagination.getPageData().forEach(item => {
      document.getElementById('data-list').innerHTML += `<li>${item}</li>`;
    });
    document.getElementById('pagination-buttons').innerHTML = pagination.render();
  }
});

    </script>
@endsection
