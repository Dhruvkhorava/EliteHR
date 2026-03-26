@extends('layouts.app')

@section('styles')
<style>
    :root {
        --folder-primary: #4361ee;
        --folder-secondary: #eaf1ff;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.3);
    }
    .dark {
        --glass-bg: rgba(25, 30, 58, 0.7);
        --glass-border: rgba(255, 255, 255, 0.1);
    }

    .doc-container {
        padding: 20px 0;
    }

    .folder-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .folder-item {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 25px;
        position: relative;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        text-decoration: none !important;
        overflow: hidden;
    }

    .folder-item:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-color: var(--folder-primary);
    }

    .folder-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        background: linear-gradient(135deg, var(--folder-primary), #1e3a8a);
        color: #fff;
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        transition: all 0.3s;
    }

    .folder-item:hover .folder-icon-wrapper {
        transform: rotate(-10px) scale(1.1);
    }

    .folder-info h5 {
        font-weight: 800;
        font-size: 1.1rem;
        margin-bottom: 5px;
        color: #3b3f5c;
        transition: color 0.3s;
    }

    .dark .folder-info h5 {
        color: #e0e6ed;
    }

    .folder-item:hover .folder-info h5 {
        color: var(--folder-primary);
    }

    .file-count {
        font-size: 0.85rem;
        color: #888ea8;
        display: flex;
        align-items: center;
    }

    .file-count i {
        width: 14px;
        height: 14px;
        margin-right: 5px;
    }

    .folder-decoration {
        position: absolute;
        right: -20px;
        bottom: -20px;
        opacity: 0.05;
        transition: all 0.5s;
    }

    .folder-item:hover .folder-decoration {
        opacity: 0.15;
        transform: scale(1.5) rotate(-15deg);
    }

    .search-header {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .search-input-group {
        position: relative;
        max-width: 500px;
    }

    .search-input-group input {
        border-radius: 30px;
        padding: 12px 25px 12px 50px;
        border: 1px solid #e0e6ed;
        background: #f1f2f3;
        width: 100%;
        transition: all 0.3s;
    }

    .search-input-group input:focus {
        background: #fff;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        border-color: var(--folder-primary);
        outline: none;
    }

    .search-input-group i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #888ea8;
        width: 18px;
    }

    /* Custom Colors for Folders */
    .color-1 .folder-icon-wrapper { background: linear-gradient(135deg, #4361ee, #1e3a8a); }
    .color-2 .folder-icon-wrapper { background: linear-gradient(135deg, #00ab55, #006633); }
    .color-3 .folder-icon-wrapper { background: linear-gradient(135deg, #e7515a, #991b1b); }
    .color-4 .folder-icon-wrapper { background: linear-gradient(135deg, #e2a03f, #92400e); }
    .color-5 .folder-icon-wrapper { background: linear-gradient(135deg, #2196f3, #0d47a1); }
    .color-6 .folder-icon-wrapper { background: linear-gradient(135deg, #9c27b0, #4a148c); }
    .color-7 .folder-icon-wrapper { background: linear-gradient(135deg, #ff5722, #bf360c); }
    .color-8 .folder-icon-wrapper { background: linear-gradient(135deg, #607d8b, #263238); }
</style>
@endsection

@section('content')
<div class="doc-container layout-top-spacing">
    
    <div class="search-header d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div>
            <h2 class="fw-bold mb-1">My Documents</h2>
            <p class="text-muted mb-md-0">Securely manage and organize your professional documents</p>
        </div>
        <div class="search-input-group mt-3 mt-md-0">
            <i data-feather="search"></i>
            <input type="text" id="folderSearch" placeholder="Search categories...">
        </div>
    </div>

    <div class="folder-grid" id="folderGrid">
        @php $i = 1; @endphp
        @foreach($categories as $key => $name)
            <a href="{{ route('documents.category', $key) }}" class="folder-item color-{{ $i }}" data-name="{{ strtolower($name) }}">
                <div class="folder-icon-wrapper">
                    <i data-feather="{{ $icons[$key] ?? 'folder' }}"></i>
                </div>
                <div class="folder-info">
                    <h5>{{ $name }}</h5>
                    <div class="file-count">
                        <i data-feather="file"></i>
                        <span>{{ $counts[$key] ?? 0 }} Files</span>
                    </div>
                </div>
                <div class="folder-decoration">
                    <i data-feather="folder" style="width: 100px; height: 100px;"></i>
                </div>
            </a>
            @php $i++; if($i > 8) $i = 1; @endphp
        @endforeach
    </div>

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        feather.replace();

        // Search functionality
        $('#folderSearch').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#folderGrid .folder-item').filter(function() {
                $(this).toggle($(this).data('name').indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
