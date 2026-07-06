/**
 * Search Scripts
 * Handles AJAX live search and filter updates.
 */
document.addEventListener('DOMContentLoaded', function() {
    
    const searchInput   = document.getElementById('searchInput');
    const clearSearch   = document.getElementById('clearSearchBtn');
    const filterForm    = document.getElementById('filterForm');
    const clearFilters  = document.getElementById('clearFiltersBtn');
    
    const resultsBody   = document.getElementById('resultsBody');
    const resultsTable  = document.querySelector('.table-responsive');
    const emptyState    = document.getElementById('emptyState');
    const loader        = document.getElementById('searchLoader');
    
    let debounceTimer;

    // Base API URL
    const basePath = window.location.pathname.includes('/public/') 
        ? window.location.pathname.substring(0, window.location.pathname.indexOf('/public/') + 7) 
        : '/';
    const apiUrl = basePath.endsWith('/') ? `${basePath}search/live` : `${basePath}/search/live`;
    const studentUrl = basePath.endsWith('/') ? `${basePath}student/` : `${basePath}/student/`;

    // Fetch and render results
    const fetchResults = async () => {
        // Show loader
        resultsTable.style.opacity = '0.5';
        
        // Build query string
        const query = searchInput.value.trim();
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        if (query) params.append('q', query);
        for (let [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }
        
        try {
            const response = await fetch(`${apiUrl}?${params.toString()}`);
            if (!response.ok) throw new Error('Network error');
            const data = await response.json();
            renderResults(data.results);
        } catch (error) {
            console.error('Search error:', error);
            resultsBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading results. Please try again.</td></tr>';
        } finally {
            resultsTable.style.opacity = '1';
        }
    };

    // Render table rows
    const renderResults = (students) => {
        resultsBody.innerHTML = '';
        
        if (students.length === 0) {
            resultsTable.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }
        
        resultsTable.style.display = 'block';
        emptyState.style.display = 'none';
        
        students.forEach(student => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="font-monospace text-muted">${student.matric_no}</td>
                <td class="fw-medium">${student.name}</td>
                <td><div class="text-truncate" style="max-width: 250px;" title="${student.programme}">${student.programme}</div></td>
                <td>${student.degree_level}</td>
                <td><span class="badge badge-status ${student.status_badge}">${student.research_status}</span></td>
                <td class="text-end">
                    <a href="${studentUrl}${student.student_id}" class="btn btn-sm btn-uum-outline">
                        View <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </td>
            `;
            resultsBody.appendChild(tr);
        });
    };

    // Event Listeners
    
    // Search input (Debounced)
    searchInput.addEventListener('input', function() {
        if (this.value.trim().length > 0) {
            clearSearch.classList.add('visible');
        } else {
            clearSearch.classList.remove('visible');
        }
        
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchResults, 300);
    });
    
    // Clear search
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        this.classList.remove('visible');
        searchInput.focus();
        fetchResults();
    });
    
    // Filter changes
    const filters = filterForm.querySelectorAll('select');
    filters.forEach(filter => {
        filter.addEventListener('change', fetchResults);
    });
    
    // Clear filters
    clearFilters.addEventListener('click', function() {
        filterForm.reset();
        fetchResults();
    });

    // Initial fetch on load
    fetchResults();
});
