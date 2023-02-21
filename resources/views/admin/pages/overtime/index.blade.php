@extends('adminlte::page')
@php
    use App\Models\Overtime;
@endphp

@section('title', __('pages.overtime.list_overtime'))

@section('content_header')
    <h3 class="m-0 text-dark">{{ __('pages.overtime.list_overtime') }}</h3>
@stop
@section('content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.overtime.index') }}">{{ __('pages.overtime.title') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('pages.overtime.list_overtime') }}</li>
    </ol>
@stop

@section('content')
    @if ( Auth::user()->isSuperAdmin() === false)
        <div class="row" id="my-overtime">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-1 mt-1">{{ __('pages.overtime.my_list_overtime') }}</h5>
                            </div>
                            <div class="text-right col-md-6">
                                @can('overtimes.create')
                                    <button class="btn btn-sm btn-outline-success"
                                        @click="redirectToUrl(`{{ route('admin.overtime.create') }}`)"><i
                                            class="fas fa-fw fa-plus"></i>{{ __('pages.overtime.store') }}</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my-table-overtime" class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>{{ __('pages.overtime.stt') }}</th>
                                        <th>{{ __('pages.overtime.name') }}</th>
                                        <th>{{ __('pages.overtime.address') }}</th>
                                        <th>{{ __('pages.overtime.phone') }}</th>
                                        <th>{{ __('pages.overtime.position') }}</th>
                                        <th>{{ __('pages.overtime.work_content') }}</th>
                                        <th>{{ __('pages.overtime.start_date') }}</th>
                                        <th>{{ __('pages.overtime.end_date') }}</th>
                                        <th>{{ __('pages.overtime.status') }}</th>
                                        <th>{{ __('pages.overtime.action') }}</th>
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
                                            {{-- <input type="text" class="form-control form-control-sm"> --}}
                                        </th>
                                        <th>
                                            {{-- <input type="text" class="form-control form-control-sm"> --}}
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myOvertimes as $index => $myOvertimeItem)
                                        <tr>
                                            <td class="text-center">{{ ++$index }}</td>
                                            <td>{{ $myOvertimeItem->name }}</td>
                                            <td>{{ $myOvertimeItem->address }}</td>
                                            <td>{{ $myOvertimeItem->phone }}</td>
                                            <td>
                                                @foreach ($roles as $role)
                                                    @if($role->id === $myOvertimeItem->position )
                                                    <span>
                                                        {{ $role->name }}
                                                    </span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $myOvertimeItem->work_content }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($myOvertimeItem->start_date)) }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($myOvertimeItem->end_date)) }}</td>
                                            <td class="text-center">
                                                @if ($myOvertimeItem->status == Overtime::STATUS_SEND)
                                                    <span class="badge bg-secondary">{{ __('app.sent') }}</span>
                                                @elseif ($myOvertimeItem->status == Overtime::STATUS_CONFIRM_LEAD)
                                                    <span class="badge bg-primary">{{ __('app.leader_confirmed') }}</span>
                                                @elseif ($myOvertimeItem->status == Overtime::STATUS_CONFIRM_ADMIN)
                                                    <span class="badge bg-success">{{ __('app.success') }}</span>
                                                @elseif($myOvertimeItem->status == Overtime::STATUS_FAIL)
                                                    <span class="badge bg-danger">{{ __('app.refuse') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @can('overtimes.edit')
                                                        <button class="btn btn-outline-{{($myOvertimeItem->status !== Overtime::STATUS_SEND) ? 'secondary' : 'primary'}} btn-sm"
                                                            {{($myOvertimeItem->status !== Overtime::STATUS_SEND) ? 'disabled' : ''}}
                                                            @click="redirectToUrl(`{{ route('admin.overtime.edit', $myOvertimeItem->id) }}`)">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                @endcan
                                                @can('overtimes.delete')
                                                    <button class="btn btn-outline-{{($myOvertimeItem->status !== Overtime::STATUS_SEND) ? 'secondary' : 'danger'}} btn-sm"
                                                        {{($myOvertimeItem->status !== Overtime::STATUS_SEND) ? 'disabled' : ''}}
                                                        @click="destroy(`{{ route('admin.overtime.destroy', $myOvertimeItem->id) }}`)">
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
        </div>
    @endif
   
    @can('confirm_from_leader', 'confirm_from_director')
        <div class="row" id="overtime-list">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-1 mt-1">{{ __('pages.overtime.list_overtime') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="overtime-table" class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>{{ __('pages.overtime.stt') }}</th>
                                        <th>{{ __('pages.overtime.name') }}</th>
                                        <th>{{ __('pages.overtime.address') }}</th>
                                        <th>{{ __('pages.overtime.phone') }}</th>
                                        <th>{{ __('pages.overtime.position') }}</th>
                                        <th>{{ __('pages.overtime.work_content') }}</th>
                                        <th>{{ __('pages.overtime.start_date') }}</th>
                                        <th>{{ __('pages.overtime.end_date') }}</th>
                                        <th>{{ __('pages.overtime.status') }}</th>
                                        <th>{{ __('pages.overtime.action') }}</th>
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
                                            {{-- <input type="text" class="form-control form-control-sm"> --}}
                                        </th>
                                        <th>
                                            {{-- <input type="text" class="form-control form-control-sm"> --}}
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($overTimes as $index => $overTimeItem)
                                        <tr>
                                            <td class="text-center">{{ ++$index }}</td>
                                            <td>{{ $overTimeItem->name }}</td>
                                            <td>{{ $overTimeItem->address }}</td>
                                            <td>{{ $overTimeItem->phone }}</td>
                                            <td>
                                                @foreach ($roles as $role)
                                                    @if($role->id === $overTimeItem->position )
                                                    <span>
                                                        {{ $role->name }}
                                                    </span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $overTimeItem->work_content }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($overTimeItem->start_date)) }}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($overTimeItem->end_date)) }}</td>
                                            <td class="text-center">
                                                @if ($overTimeItem->status == Overtime::STATUS_SEND)
                                                    <span class="badge bg-secondary">{{ __('app.sent') }}</span>
                                                @elseif ($overTimeItem->status == Overtime::STATUS_CONFIRM_LEAD)
                                                    <span class="badge bg-primary">{{ __('app.leader_confirmed') }}</span>
                                                @elseif ($overTimeItem->status == Overtime::STATUS_CONFIRM_ADMIN)
                                                    <span class="badge bg-success">{{ __('app.success') }}</span>
                                                @elseif($overTimeItem->status == Overtime::STATUS_FAIL)
                                                    <span class="badge bg-danger">{{ __('app.refuse') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- @if (auth()->user()->isSuperAdmin())
                                                    @can('overtimes.edit')
                                                        <button class="btn btn-outline-primary btn-sm"
                                                            @click="redirectToUrl(`{{ route('admin.overtime.edit', $overTimeItem->id) }}`)">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    @endcan
                                                    @can('overtimes.delete')
                                                        <button class="btn btn-outline-danger btn-sm"
                                                            @click="destroy(`{{ route('admin.overtime.destroy', $overTimeItem->id) }}`)">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endcan
                                                @endif --}}
                                                @if (auth()->user()->isSuperAdmin())
                                                    <button class="btn btn-outline-success btn-sm"
                                                        @click="updateStatus(`{{ route('admin.updateStatusOvertime', $overTimeItem->id) }}`,`{{ route('admin.updateStatusFailOvertime', $overTimeItem->id) }}`)">
                                                        <i class="fas fa-clipboard-check"></i>
                                                    </button>
                                                @elseif(auth()->user()->isLeader())
                                                    @if($overTimeItem->status !== Overtime::STATUS_SEND)
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                                            <i class="fas fa-clipboard-check"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-outline-success btn-sm" @click="updateStatus(`{{ route('admin.updateStatusOvertime', $overTimeItem->id) }}`,`{{ route('admin.updateStatusFailOvertime', $overTimeItem->id) }}`)">
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
        const CREATE_OVERTIME_TEXT = null;
        const CREATE_OVERTIME_URL = '{{ route('admin.overtime.create') }}';
        const canAddOvertime =
            @can('overtimes.create')
                true
            @else
                false
            @endcan ;
    </script>
    @if (auth()->user()->isSuperAdmin() ||  auth()->user()->isLeader())
        <script type="module" src="{{ asset('/assets/admin/js/pages/overtime-list.js') }}"></script>
    @endif
    @if (!auth()->user()->isSuperAdmin())
        <script type="module" src="{{ asset('/assets/admin/js/pages/my-overtime-list.js') }}"></script>
    @endif
@stop
