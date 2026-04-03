@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .form-label {
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 12px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-submit {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .image-preview {
            width: 100%;
            height: 200px;
            border-radius: 12px;
            border: 2px dashed #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f9fafb;
            cursor: pointer;
            position: relative;
        }
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        .image-preview i {
            font-size: 2rem;
            color: #9ca3af;
        }
    </style>
@endsection

@section('content')
    <div class="row layout-top-spacing justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12 layout-spacing">
            <div class="form-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="font-weight-bold">Create New Blog Post</h4>
                    <a href="{{ route('blogs.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <label class="form-label">Blog Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter post title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Category</label>
                                <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" placeholder="e.g. Workforce, Payroll, Recruitment" value="{{ old('category') }}">
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Excerpt / Short Description</label>
                                <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3" placeholder="A brief summary for the list view">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Content</label>
                                <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="12" placeholder="Write your full blog post here..." required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 text-center">
                                <label class="form-label d-block">Featured Image</label>
                                <div class="image-preview" onclick="document.getElementById('image-input').click()">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <img id="preview-img" src="" alt="Preview">
                                </div>
                                <input type="file" name="image" id="image-input" class="d-none" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted mt-2 d-block">Recommended size: 800x600px</small>
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card bg-light border-0 rounded-4 p-3 mb-4">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" checked value="1">
                                    <label class="form-check-label font-weight-bold" for="is_published">Publish Immediately</label>
                                </div>
                                <p class="small text-muted mb-0">Uncheck to save as a draft and publish later.</p>
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit w-100 text-white">
                                <i class="fas fa-paper-plane me-2"></i> Save Blog Post
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview-img');
            const icon = document.querySelector('.image-preview i');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    icon.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
