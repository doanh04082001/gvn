@extends('adminlte::page')

@section('title', __('pages.apply_leave.title'))
@php
    use App\Models\ApplyLeave;
@endphp
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
@section('css')
    <style>
        .swal2-deny:hover {
            background-color: darkred !important;
            border-color: darkred !important;
        }
        .swal2-actions{
            column-gap: 10px !important;
        }
    </style>
@stop

@section('content')
    @if ( Auth::user()->isSuperAdmin() === false)
        <div class="row" id="list">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-1 mt-1">{{ __('pages.apply_leave.list_apply') }}</h5>
                            </div>
                            <div class="text-right col-md-6">
                                @can('apply_leaves.create')
                                    <button class="btn btn-sm btn-outline-success"
                                        @click="redirectToUrl(`{{ route('admin.apply-leaves.create') }}`)"><i
                                            class="fas fa-fw fa-plus"></i>{{ __('pages.apply_leave.store') }}</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-on-my" class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>{{ __('pages.apply_leave.stt') }}</th>
                                        <th>{{ __('pages.apply_leave.name') }}</th>
                                        <th>{{ __('pages.apply_leave.address') }}</th>
                                        <th>{{ __('pages.apply_leave.phone') }}</th>
                                        <th>{{ __('pages.apply_leave.position') }}</th>
                                        <th>{{ __('pages.apply_leave.reason') }}</th>
                                        <th>{{ __('pages.apply_leave.start_date') }}</th>
                                        <th>{{ __('pages.apply_leave.end_date') }}</th>
                                        <th>{{ __('pages.apply_leave.status') }}</th>
                                        <th>{{ __('pages.apply_leave.action') }}</th>
                                    </tr>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($my_leaves as $index => $my_leave_item)
                                        <tr>
                                            <td class="text-center">{{ ++$index }}</td>
                                            <td>{{ $my_leave_item->name }}</td>
                                            <td>{{ $my_leave_item->address }}</td>
                                            <td>{{ $my_leave_item->phone }}</td>
                                            <td>
                                                @foreach ($roles as $role)
                                                    @if($role->id === $my_leave_item->position )
                                                    <span>
                                                        {{ $role->name }}
                                                    </span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $my_leave_item->reason }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($my_leave_item->start_date)) }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($my_leave_item->end_date)) }}</td>
                                            <td class="text-center">
                                                @if ($my_leave_item->status == ApplyLeave::STATUS_SEND)
                                                    <span class="badge bg-secondary">{{ __('app.sent') }}</span>
                                                @elseif ($my_leave_item->status == ApplyLeave::STATUS_CONFIRM_LEAD)
                                                    <span class="badge bg-primary">{{ __('app.leader_confirmed') }}</span>
                                                @elseif ($my_leave_item->status == ApplyLeave::STATUS_SUCCESS)
                                                    <span class="badge bg-success">{{ __('app.success') }}</span>
                                                @elseif($my_leave_item->status == ApplyLeave::STATUS_FAIL)
                                                    <span class="badge bg-danger">{{ __('app.refuse') }}</span>
                                                @endif
                                            </td>
                                            <td class="">
                                                @can('apply_leaves.edit')
                                                    <button class="btn btn-outline-{{($my_leave_item->status !== ApplyLeave::STATUS_SEND) ? 'secondary' : 'primary'}} btn-sm"
                                                        {{($my_leave_item->status !== ApplyLeave::STATUS_SEND) ? 'disabled' : ''}}
                                                        @click="redirectToUrl(`{{ route('admin.apply-leaves.edit', $my_leave_item->id) }}`)">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                @endcan
                                                @can('apply_leaves.delete')
                                                    <button class="btn btn-outline-{{($my_leave_item->status !== ApplyLeave::STATUS_SEND) ? 'secondary' : 'danger'}} btn-sm"
                                                        {{($my_leave_item->status !== ApplyLeave::STATUS_SEND) ? 'disabled' : ''}}
                                                        @click="destroy(`{{ route('admin.apply-leaves.destroy', $my_leave_item->id) }}`)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="topping-modal" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-outline-secondary btn-sm pl-4 pr-4"
                                data-dismiss="modal">{{ __('app.cancel_button_text') }}</button>
                            <button type="button"
                                class="btn btn-outline-success btn-sm pl-4 pr-4">{!! __('app.save_button_text') !!}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @can('confirm_from_leader')
        <div class="row" id="apply-leave-list">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h5>{{ __('pages.apply_leave.list_apply_leave') }}</h5>
                        <div class="table-responsive">
                            <table id="apply-leave-table" class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>{{ __('pages.apply_leave.stt') }}</th>
                                        <th>{{ __('pages.apply_leave.name') }}</th>
                                        <th>{{ __('pages.apply_leave.address') }}</th>
                                        <th>{{ __('pages.apply_leave.phone') }}</th>
                                        <th>{{ __('pages.apply_leave.position') }}</th>
                                        <th>{{ __('pages.apply_leave.reason') }}</th>
                                        <th>{{ __('pages.apply_leave.start_date') }}</th>
                                        <th>{{ __('pages.apply_leave.end_date') }}</th>
                                        <th>{{ __('pages.apply_leave.status') }}</th>
                                        <th>{{ __('pages.apply_leave.action') }}</th>                                    
                                    </tr>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        
                                        <th>
                                            <input type="text" class="form-control form-control-sm">
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                            {{-- <input type="text" class="form-control form-control-sm"> --}}
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($apply_leaves as $index => $apply_leave_item)
                                        <tr>
                                            <td class="text-center">{{ ++$index }}</td>
                                            <td>{{ $apply_leave_item->name }}</td>
                                            <td>{{ $apply_leave_item->address }}</td>
                                            <td>{{ $apply_leave_item->phone }}</td>
                                            <td>
                                                @foreach ($roles as $role)
                                                    @if($role->id === $apply_leave_item->position )
                                                    <span>
                                                        {{ $role->name }}
                                                    </span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $apply_leave_item->reason }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($apply_leave_item->start_date)) }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($apply_leave_item->end_date)) }}</td>
                                            <td class="text-center">
                                                @if ($apply_leave_item->status == ApplyLeave::STATUS_SEND)
                                                    <span class="badge bg-secondary">{{ __('app.sent') }}</span>
                                                @elseif ($apply_leave_item->status == ApplyLeave::STATUS_CONFIRM_LEAD)
                                                    <span class="badge bg-primary">{{ __('app.leader_confirmed') }}</span>
                                                @elseif ($apply_leave_item->status ==  ApplyLeave::STATUS_SUCCESS)
                                                    <span class="badge bg-success">{{ __('app.success') }}</span>
                                                @elseif($apply_leave_item->status == ApplyLeave::STATUS_FAIL)
                                                    <span class="badge bg-danger">{{ __('app.refuse') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (auth()->user()->isSuperAdmin())
                                                    <button class="btn btn-outline-success btn-sm"
                                                        @click="updateStatus(`{{ route('admin.updateStatus', $apply_leave_item->id) }}`,`{{ route('admin.updateStatusFail', $apply_leave_item->id) }}`)">
                                                        <i class="fas fa-clipboard-check"></i>
                                                    </button>
                                                @elseif(auth()->user()->isLeader())
                                                    @if($apply_leave_item->status !== ApplyLeave::STATUS_SEND)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                                            <i class="fas fa-clipboard-check"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-outline-success btn-sm" @click="updateStatus(`{{ route('admin.updateStatus', $apply_leave_item->id) }}`,`{{ route('admin.updateStatusFail', $apply_leave_item->id) }}`)">
                                                            <i class="fas fa-clipboard-check"></i>
                                                        </button>
                                                    @endif
                                                
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@stop

@section('js')
    <script>
        const message = '{!! session()->get('success') ?? null !!}';
        const CREATE_APPLY_TEXT = null;
        const CREATE_APPLY_URL = '{{ route('admin.apply-leaves.create') }}';
        const canAddApply =
            @can('apply.create')
                true
            @else
                false
            @endcan ;
    </script>
     @if (auth()->user()->isSuperAdmin() ||  auth()->user()->isLeader())
        <script type="module" src="{{ asset('/assets/admin/js/pages/apply-leave-list.js') }}"></script>
     @endif
    @if (!auth()->user()->isSuperAdmin())
        <script type="module" src="{{ asset('/assets/admin/js/pages/my-apply-leave-list.js') }}"></script>
    @endif
@stop
