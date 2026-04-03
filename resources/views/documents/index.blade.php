@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/documents_index.css') }}">
@endsection

@section('content')
<div class="doc-container layout-top-spacing">
    
    <div class="search-header d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div class="header-content">
            <h2 class="fw-bold mb-1">My Documents</h2>
            <p class="text-muted mb-md-0">Securely manage and organize your professional documents</p>
        </div>
        <div class="search-input-group mt-4 mt-md-0">
            <input type="text" id="folderSearch" placeholder="Search categories...">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div>

    @php
        $faIcons = [
            'user' => 'fa-user-tie',
            'book' => 'fa-graduation-cap',
            'briefcase' => 'fa-briefcase-clock',
            'activity' => 'fa-heart-pulse',
            'credit-card' => 'fa-wallet',
            'more-horizontal' => 'fa-layer-group',
            'folder' => 'fa-folder-open'
        ];
    @endphp

    <div class="folder-grid" id="folderGrid">
        @php $i = 1; @endphp
        @foreach($categories as $key => $name)
            @php 
                $iconName = $icons[$key] ?? 'folder';
                $faIcon = $faIcons[$iconName] ?? $faIcons['folder'];
            @endphp
            <a href="{{ route('documents.category', $key) }}" class="folder-item color-{{ $i }}" data-name="{{ strtolower($name) }}">
                <div class="folder-icon-wrapper">
                    <i class="fa-solid {{ $faIcon }}"></i>
                </div>
                <div class="folder-info">
                    <h5>{{ $name }}</h5>
                    <div class="file-count">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>{{ $counts[$key] ?? 0 }} Files</span>
                    </div>
                </div>
                <div class="folder-decoration">
                    <i class="fa-solid {{ $faIcon }}"></i>
                </div>
            </a>
            @php $i++; if($i > 8) $i = 1; @endphp
        @endforeach

        {{-- No Results State --}}
        <div id="noResults">
            <i class="fa-solid fa-folder-open"></i>
            <h4>No categories found</h4>
            <p class="text-muted">Try a different search term</p>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script src="{{ asset('asset/js/documents_index.js') }}"></script>
@endsection

