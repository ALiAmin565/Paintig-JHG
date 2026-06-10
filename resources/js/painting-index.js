export function initLivePaintingIndexFilter() {
    const form = document.querySelector('[data-live-painting-filter-form]');
    const resultsContainer = document.querySelector('[data-live-painting-results]');
    const countEl = document.querySelector('[data-paintings-count]');
    const clearBtn = document.querySelector('[data-clear-filters]');

    if (!form || !resultsContainer) {
        return;
    }

    let debounceTimer = null;

    function hasActiveFilters() {
        const formData = new FormData(form);

        for (const [key, value] of formData.entries()) {
            if (!value) {
                continue;
            }

            if (key === 'sort' && value === 'created_desc') {
                continue;
            }

            return true;
        }

        return false;
    }

    function updateClearButton() {
        if (!clearBtn) {
            return;
        }

        clearBtn.classList.toggle('hidden', !hasActiveFilters());
    }

    function updateCount(total) {
        if (!countEl) {
            return;
        }

        const label = total === 1 ? 'record' : 'records';
        countEl.textContent = `${total} ${label} in catalog`;
    }

    function runFilter(url) {
        const targetUrl = url || (() => {
            const params = new URLSearchParams(new FormData(form));
            return `${form.action}?${params.toString()}`;
        })();

        resultsContainer.classList.add('opacity-60', 'pointer-events-none');

        fetch(targetUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'text/html',
            },
        })
            .then(function (response) {
                return response.text();
            })
            .then(function (html) {
                resultsContainer.innerHTML = html;
                resultsContainer.classList.remove('opacity-60', 'pointer-events-none');

                const meta = resultsContainer.querySelector('#paintings-results-meta');
                if (meta) {
                    updateCount(parseInt(meta.dataset.total, 10) || 0);
                    meta.remove();
                }

                updateClearButton();

                if (window.history && window.history.replaceState) {
                    window.history.replaceState({}, '', targetUrl);
                }
            })
            .catch(function () {
                resultsContainer.classList.remove('opacity-60', 'pointer-events-none');
            });
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        runFilter();
    });

    form.querySelectorAll('[data-live-search-trigger]').forEach(function (input) {
        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                runFilter();
            }, 350);
        });

        input.addEventListener('change', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                runFilter();
            }, 100);
        });
    });

    form.addEventListener('live-filter-change', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            runFilter();
        }, 100);
    });

    resultsContainer.addEventListener('click', function (event) {
        const paginationLink = event.target.closest('#paintings-pagination a, .pagination-nav a');
        if (!paginationLink) {
            return;
        }

        event.preventDefault();
        runFilter(paginationLink.href);
    });

    updateClearButton();
}
