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
