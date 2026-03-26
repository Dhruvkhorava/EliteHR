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

<style>
.search-input-container input::placeholder {
    color: #bfc9d4;
}

.search-result-item {
    padding: 12px 15px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 5px;
    text-decoration: none !important;
}

.search-result-item:hover, .search-result-item.active {
    background: rgba(67, 97, 238, 0.08);
}

.search-result-icon {
    width: 40px;
    height: 40px;
    background: #f1f2f3;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4361ee;
}

.search-result-info {
    margin-left: 15px;
}

.search-result-title {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0;
    font-size: 0.95rem;
}

.search-result-subtitle {
    font-size: 0.75rem;
    color: #64748b;
}

.search-result-type {
    margin-left: auto;
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #e2e8f0;
    padding: 2px 8px;
    border-radius: 20px;
    color: #475569;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('globalSearchTrigger');
    const input = document.getElementById('global-search-input');
    const resultsContainer = document.getElementById('global-search-results');
    const modal = new bootstrap.Modal(document.getElementById('searchModal'));
    let debounceTimer;

    // 1. Open Modal on trigger click or Ctrl+K
    trigger?.addEventListener('click', () => modal.show());
    
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            modal.show();
        }
    });

    // 2. Focus input on modal show
    document.getElementById('searchModal').addEventListener('shown.bs.modal', () => {
        input.focus();
    });

    // 3. Handle Live Search
    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            resultsContainer.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetchSearch(query);
        }, 300);
    });

    async function fetchSearch(query) {
        try {
            const response = await fetch(`/dashboard/api/unified-search?query=${encodeURIComponent(query)}`);
            const data = await response.json();
            renderResults(data.results);
        } catch (error) {
            console.error('Search error:', error);
        }
    }

    function renderResults(results) {
        if (results.length === 0) {
            resultsContainer.innerHTML = '<div class="p-4 text-center text-muted">No results found for your query.</div>';
        } else {
            resultsContainer.innerHTML = results.map((res, index) => `
                <a href="${res.url}" class="search-result-item ${index === 0 ? 'active' : ''}">
                    <div class="search-result-icon">
                        <i data-feather="${res.icon}"></i>
                    </div>
                    <div class="search-result-info">
                        <p class="search-result-title">${res.title}</p>
                        <p class="search-result-subtitle">${res.subtitle}</p>
                    </div>
                    <span class="search-result-type">${res.type}</span>
                </a>
            `).join('');
            
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
        resultsContainer.style.display = 'block';
    }

    // 4. Keyboard Navigation
    input.addEventListener('keydown', function(e) {
        const active = resultsContainer.querySelector('.search-result-item.active');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            const next = active?.nextElementSibling || resultsContainer.querySelector('.search-result-item');
            active?.classList.remove('active');
            next?.classList.add('active');
            next?.scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            const prev = active?.previousElementSibling || resultsContainer.querySelectorAll('.search-result-item')[resultsContainer.querySelectorAll('.search-result-item').length - 1];
            active?.classList.remove('active');
            prev?.classList.add('active');
            prev?.scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'Enter') {
            if (active) {
                window.location.href = active.href;
            }
        }
    });
});
</script>
