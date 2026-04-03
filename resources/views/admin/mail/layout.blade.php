@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/assets/apps/mailbox.scss'])
    @vite(['resources/scss/dark/assets/apps/mailbox.scss'])
    <link rel="stylesheet" href="{{ asset('asset/css/admin_mail_layout.css') }}">
@endsection

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12">
        <div class="mail-sidebar">
            <div class="d-grid gap-2 mb-4">
                <a href="{{ route('mail.compose') }}" class="btn btn-primary">Compose</a>
            </div>
            <ul class="mail-menu">
                <li class="{{ Request::routeIs('mail.index') ? 'active' : '' }}">
                    <a href="{{ route('mail.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
                        Inbox
                    </a>
                </li>
                <li class="{{ Request::routeIs('mail.sent') ? 'active' : '' }}">
                    <a href="{{ route('mail.sent') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        Sent
                    </a>
                </li>
                <li class="{{ Request::routeIs('mail.drafts') ? 'active' : '' }}">
                    <a href="{{ route('mail.drafts') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        Drafts
                    </a>
                </li>
                <li class="{{ Request::routeIs('mail.trash') ? 'active' : '' }}">
                    <a href="{{ route('mail.trash') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        Trash
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
        <div class="mail-content-container">
            @yield('mail-content')
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/apps/mailbox.js'])
@endsection
