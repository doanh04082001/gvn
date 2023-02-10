@extends('adminlte::partials.navbar.navbar')

@section('content_top_nav_right')
    <li id="notification-container" class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" @click="firstLoading">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge" v-if="totalUnread">@{{ totalUnread }}</span>
        </a>
        <div id="notification-list" 
            class="dropdown-menu dropdown-menu-xl dropdown-menu-right max-height-90 notification-dropdown-container" 
            @scroll="loadMore">
            <div class="dropdown-item dropdown-header clearfix">
                <span class="float-left">
                    <span v-if="totalUnread">@{{ totalUnread }}</span>
                    {{ __('adminlte::adminlte.notifications') }}
                </span>
                <span class="float-right read-all" @click="markAllAsRead($event)">{{ __('adminlte::adminlte.notification_read_all') }}</span>
            </div>
            <template v-for="notification in notifications">
                <a :href="notification.web_push_url"
                    class="row mx-2 rounded py-2 a-none notification-item" 
                    :class="{'opacity-75': notification.read_at}" @click="markAsRead(notification.id)">
                    <div class="col-2 d-flex justify-content-center align-items-center notification-icon-container">
                        <i :class="notification.icon"></i>
                    </div>
                    <div class="col-9 d-flex flex-column">
                        <div class="mb-1">@{{ notification.title }}</div>
                        <div class="mb-1">@{{ notification.body }}</div>
                        <small :class="{'text-light-primary text-bold': !notification.read_at}" :key="keyChange">
                            @{{ diffFromNow(notification.created_at) }}
                        </small>
                    </div>
                    <template v-if="!notification.read_at">
                        <small class="col-1 d-flex text-dark-primary justify-content-center align-items-center mark-as-read" @click="markAsRead(notification.id, $event)">
                            <i class="fas fa-circle"></i>
                        </small>
                    </template>
                </a>
            </template>
            <template v-if="isLoading">
                <div class="row mx-2 rounded py-2 loading-item align-items-center" v-for="index in isInit ? 2 : 15">
                    <div class="col-2">
                        <div class="loading-icon bg-loading"></div>
                    </div>
                    <div class="col-10">
                        <div class="loading-message bg-loading"></div>
                    </div>
                </div>
            </template>
        </div>
    </li>
@endsection
