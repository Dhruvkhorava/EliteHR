@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom mb-3">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Blog Management</h5>
                        <p class="text-muted mb-0 small">Manage your website blog posts and insights.</p>
                    </div>
                    <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-lg px-4 shadow-none">
                        <i class="fas fa-plus me-2"></i> Add New Blog
                    </a>
                </div>
                <div class="px-4 pb-4">
                    <table id="blogs-table" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($blog->image)
                                                <img src="{{ asset('storage/' . $blog->image) }}" class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="rounded me-2 bg-light d-flex align-items-center justify-content-center" width="40" height="40">
                                                    <i class="far fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <span>{{ Str::limit($blog->title, 40) }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-light-info">{{ $blog->category ?? 'Uncategorized' }}</span></td>
                                    <td>{{ $blog->author->name }}</td>
                                    <td class="text-center">
                                        @if($blog->is_published)
                                            <span class="badge badge-light-success">Published</span>
                                        @else
                                            <span class="badge badge-light-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td class="text-center small">{{ $blog->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm confirm-delete">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#blogs-table').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                   "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [7, 10, 20, 50],
                "pageLength": 10
            });

            $('.confirm-delete').on('click', function(e) {
                if(!confirm('Are you sure you want to delete this blog post?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
