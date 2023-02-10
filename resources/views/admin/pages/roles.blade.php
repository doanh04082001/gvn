@extends('adminlte::page')

@section('title', __('adminlte::menu.role_manage'))

@section('content_header')
<h4 class="m-0 text-dark">{{ __('adminlte::menu.roles_and_permissions') }}</h4>
@stop

@section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.roles.index') }}">
            {{ __('adminlte::menu.roles_and_permissions') }}
        </a>
    </li>
    <li class="breadcrumb-item active">{{ __('adminlte::menu.role_manage') }}</li>
</ol>
@stop

@section('content')
<div id="role-page">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-1 mt-1">{{ __('adminlte::menu.role_manage') }}</h5>
                        </div>
                        @can('roles.create')
                        <div class="col-6 text-right">
                            <button class="btn btn-sm btn-outline-success" @click="toCreate">
                                <i class="fas fa-fw fa-plus"></i>
                                {{ __('pages.roles.create_role_text') }}
                            </button>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="role-table">
                        <thead>
                            <tr>
                                <th style="width: 10px" class="text-center">#</th>
                                <th>{{ __('pages.roles.role_name') }}</th>
                                <th class="text-center" data-searching="false" data-orderable="false">
                                    {{ __('app.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(role, index) in roles">
                                <td class="align-middle text-center">@{{ index+1 }}</td>
                                <td class="align-middle">@{{ role.name }}</td>
                                <td class="align-middle text-center">
                                    @can('roles.edit')
                                    <button class="btn btn-sm btn-outline-primary"
                                        title="{{ __('pages.roles.assign_permission_text') }}"
                                        @click="toAssignPermission(`{{ adminUrl() }}/roles/${role.id}/permissions`)">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary"
                                        title="{{ __('pages.roles.edit_role_text') }}"
                                        @click="toEdit(role, `{{ adminUrl() }}/roles/${role.id}`)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endcan

                                    @can('roles.delete')
                                    <button class="btn btn-sm btn-outline-danger"
                                        title="{{ __('pages.roles.delete_role_text') }}"
                                        @click="toRemove(role.id, `{{ adminUrl() }}/roles/${role.id}`)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="modal fade" id="role-modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@{{ modal.title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="inputEmail3"
                            class="col-md-4 col-form-label">{{ __('pages.roles.role_name') }}:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" v-model="roleForm.name">
                            <div v-for="message in (errorsForm.name)" class="invalid-feedback d-block">
                                <strong>@{{ message }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        {{ __('app.cancel_button_text') }}
                    </button>
                    <button type="button" :class="'btn ' + modal.okButtonClass" @click="submitRole">
                        @{{ modal.okButtonText }}
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@stop

@section('js')
<script>
    const ROLES = @json($roles);
    const CREATE_ROLE_TEXT = `{{ __('pages.roles.create_role_text') }}`
    const EDIT_ROLE_TEXT = `{{ __('pages.roles.edit_role_text') }}`
    const EDIT_ROLE_BUTTON_TEXT = `{{ __('app.save_button_text') }}`
    const DELETE_ROLE_CONFIRM_TEXT = `{{ __('pages.roles.delete_role_text') }}`
    const MODAL_CREATE_CONFIG = {
        title: CREATE_ROLE_TEXT,
        okButtonText: `{{ __('app.add_button_text') }}`,
        okButtonClass: 'btn-outline-success',
        action: {
            method: 'POST',
            url: `{{ adminUrl() . '/roles' }}`
        }
    }
</script>
<script type="module" src="{{ asset('assets/admin/js/pages/role.js') }}"></script>
@endsection
