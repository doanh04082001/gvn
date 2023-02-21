@extends('adminlte::page')

@section('css')
<link href="{{ asset('/vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('title', __('adminlte::menu.permission_manage'))

@section('content_header')
<h4 class="m-0 text-dark">
    {!! __('adminlte::menu.roles_and_permissions') !!}
</h4>
@stop

@section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.roles.index') }}">
            {{ __('adminlte::menu.roles_and_permissions') }}
        </a>
    </li>
    <li class="breadcrumb-item active">{{ __('adminlte::menu.permission_manage') }}</li>
</ol>
@stop

@section('content')
<div id="permission-page">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-1 mt-1">{{ __('adminlte::menu.permission_manage') }}</h5>
                        </div>
                        @can('roles.edit')
                        <div class="col-6 text-right">
                            <button v-if="showPermissionButton" class="btn btn-sm btn-outline-secondary"
                                @click="toRevertConfig">
                                <i class="fas fa-fw fa-undo"></i>
                                {{ __('pages.permissions.revert_button_text') }}
                            </button>
                            <button v-if="showPermissionButton" class="btn btn-sm btn-outline-success"
                                @click="toSaveConfig">
                                <i class="fas fa-fw fa-save"></i>
                                {{ __('pages.permissions.save_button_text') }}
                            </button>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body border-top border-grey">
                    <table class="table" id="permission-table">
                        <thead>
                            <tr>
                                <th>{{ __('pages.permissions.permission_name') }}</th>
                                <th class="text-center" data-searching="false">
                                    {{ __('app.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(groupValue, group) in mapping">
                                <tr class="group-row">
                                    <th class="group align-middle text-left">@{{ languages[group] }}</th>
                                    <td class="align-middle text-center">
                                        <div class="icheck-success d-inline">
                                            <input @cannot('roles.edit') disabled @endcan type="checkbox" :id="group"
                                                v-model="mapping[group]['hasGroupPermission']"
                                                @change="handleChangeGroup(group)">
                                            <label :for="group">
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="(permissionValue, permission) in groupValue.permissions">
                                    <td class="align-middle text-left">@{{ languages[permission] }}</td>
                                    <td class="align-middle text-center">
                                        <div class="icheck-success d-inline">
                                            <input @cannot('roles.edit') disabled @endcan type="checkbox"
                                                :id="permission" v-model="mapping[group]['permissions'][permission]"
                                                @change="handleChangePermission(group)">
                                            <label :for="permission">
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    const ROLE = @json($role);
    const ROLES = @json($roles);
    const MAPPING = @json($mapping);
    const LANGUAGES = @json($languages);
    const SAVE_PERMISSION_URL = `{{ route('admin.roles.permissions.store', ['role' => $role->id]) }}`;
    const ROLES_DROPDOWN_TEXT = `{{ __('pages.permissions.roles_dropdown_label') }}`;
</script>
<script type="module" src="{{ asset('assets/admin/js/pages/permission.js') }}"></script>
@endsection
