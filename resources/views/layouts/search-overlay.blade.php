<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 50px rgba(0,0,0,0.15);">
            <div class="modal-body p-0">
                <div class="search-input-container p-4 d-flex align-items-center border-bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4361ee" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="global-search-input" class="form-control border-0 shadow-none" placeholder="Search employees, candidates, jobs..." style="font-size: 1.25rem; font-weight: 600;">
                    <button type="button" class="btn-close ms-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="search-results-container p-2" id="global-search-results" style="max-height: 400px; overflow-y: auto; display: none;">
                    <!-- Results will be injected here -->
                </div>
                <div class="search-footer p-3 bg-light d-flex justify-content-between align-items-center" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                    <div class="d-flex gap-3">
                        <small class="text-muted"><kbd class="bg-white text-dark border shadow-sm">Enter</kbd> to select</small>
                        <small class="text-muted"><kbd class="bg-white text-dark border shadow-sm">↑↓</kbd> to navigate</small>
                    </div>
                    <small class="text-primary font-weight-bold">Powered by Search Infrastructure</small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/layouts_search_overlay.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('asset/js/layouts_search_overlay.js') }}"></script>
@endpush
