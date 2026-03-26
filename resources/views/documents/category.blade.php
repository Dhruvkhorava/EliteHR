@extends('layouts.app')

@section('styles')
<style>
    .upload-area {
        border: 2px dashed #4361ee;
        border-radius: 15px;
        padding: 40px;
        text-align: center;
        background: rgba(67, 97, 238, 0.05);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-area:hover {
        background: rgba(67, 97, 238, 0.1);
        border-style: solid;
    }
    .doc-list-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .dark .doc-list-card {
        background: #191e3a;
    }
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-uploaded { background: rgba(67, 97, 238, 0.1); color: #4361ee; }
    .status-verified { background: rgba(0, 171, 85, 0.1); color: #00ab55; }
    .status-rejected { background: rgba(231, 81, 90, 0.1); color: #e7515a; }
</style>
@endsection

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="widget-content widget-content-area p-4 br-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0">{{ $categoryName }}</h4>
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                    <i data-feather="arrow-left" class="me-1"></i> Back to Categories
                </a>
            </div>

            <!-- Upload Section -->
            <div class="row mb-5 justify-content-center">
                <div class="col-md-8">
                    <div class="upload-area" id="uploadTrigger" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i data-feather="upload-cloud" style="width: 48px; height: 48px; color: #4361ee; margin-bottom: 15px;"></i>
                        <h5>Click to Upload New Document</h5>
                        <p class="text-muted mb-0">PDF, JPG, PNG, DOC (Max 10MB)</p>
                    </div>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered doc-list-card">
                    <thead class="bg-light">
                        <tr>
                            <th>Document Title</th>
                            <th>Status</th>
                            <th>Uploaded Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i data-feather="file" class="me-2 text-primary"></i>
                                        <span class="fw-bold">{{ $doc->title }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $doc->status }}">
                                        {{ $doc->status }}
                                    </span>
                                </td>
                                <td>{{ $doc->created_at->format('M d, Y h:i A') }}</td>
                                <td class="text-center">
                                    <div class="dropdown custom-dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $doc->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $doc->id }}">
                                            <a class="dropdown-item" href="{{ route('documents.download', $doc->id) }}">
                                                <i data-feather="download" class="me-2 text-success"></i> Download
                                            </a>
                                            <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item confirm-delete">
                                                    <i data-feather="trash-2" class="me-2 text-danger"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="{{ asset('asset/images/notfound.png') }}" alt="" style="width: 100px; opacity: 0.5;">
                                    <p class="mt-3 text-muted">No documents found in this category.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
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
                        <input type="text" name="title" class="form-control" placeholder="e.g., Aadhaar Card Front" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select File</label>
                        <input type="file" name="document" class="form-control" required>
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
<script>
    $(document).ready(function() {
        feather.replace();
    });
</script>
@endsection
