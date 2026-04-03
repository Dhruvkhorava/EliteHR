@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/documents_category.css') }}?v=1.0.1">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="widget-content widget-content-area p-4 br-8">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="mb-0">{{ $categoryName }}</h4>
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Categories
                    </a>
                </div>

                <!-- Upload Section -->
                <div class="row mb-5 justify-content-center">
                    <div class="col-md-8">
                        <div class="upload-area" id="uploadTrigger" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fa-solid fa-cloud-arrow-up"
                                style="font-size: 48px; color: #4361ee; margin-bottom: 15px;"></i>
                            <h5>Click to Upload New Document</h5>
                            <p class="text-muted mb-0">PDF, JPG, PNG, DOC (Max 10MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Documents Grid -->
                <div class="file-grid">
                    @forelse($documents as $doc)
                        <div class="position-relative">
                            <div class="file-card">
                                <div class="file-status-container">
                                    <span class="status-badge status-{{ $doc->status }}">
                                        {{ $doc->status }}
                                    </span>
                                </div>

                                <div class="file-icon-wrapper">
                                    <div class="document-icon"></div>
                                </div>

                                <div class="file-info">
                                    <span class="file-title" title="{{ $doc->title }}">{{ $doc->title }}</span>
                                    <span class="file-date">{{ $doc->created_at->format('M d, Y') }}</span>
                                </div>

                                <!-- Actions -->
                                <div class="file-actions">
                                    <!-- View -->
                                    <a href="{{ route('documents.view', $doc->id) }}" class="action-btn btn-view-file"
                                        target="_blank" title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <!-- Download -->
                                    <a href="{{ route('documents.download', $doc->id) }}"
                                        class="action-btn btn-download-file" title="Download">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                    <!-- Delete -->
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete-file confirm-delete"
                                            title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category" value="{{ $category }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Document Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g., Aadhaar Card Front"
                                value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select File</label>
                            <input type="file" name="document" class="form-control @error('document') is-invalid @enderror">
                            @error('document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max size: 10MB (PDF, Image, Doc)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('asset/js/documents_category.js') }}"></script>
@endsection
