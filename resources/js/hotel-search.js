export function initSearchableHotelSelects() {
    document.querySelectorAll('[data-searchable-hotel-select]').forEach(function (root) {
        if (root.dataset.initialized === 'true') {
            return;
        }

        root.dataset.initialized = 'true';

        const apiUrl = root.dataset.apiUrl;
        const hiddenInput = root.querySelector('[data-hotel-id-input]');
        const searchInput = root.querySelector('[data-hotel-search-input]');
        const resultsList = root.querySelector('[data-hotel-search-results]');

        let debounceTimer = null;
        let activeIndex = -1;
        let currentResults = [];

        function closeResults() {
            resultsList.classList.add('hidden');
            activeIndex = -1;
        }

        function openResults() {
            resultsList.classList.remove('hidden');
        }

        function renderResults(hotels) {
            currentResults = hotels;
            activeIndex = -1;

            if (hotels.length === 0) {
                resultsList.innerHTML = '<li class="px-4 py-3 text-sm text-gray-500">No hotels found</li>';
                openResults();
                return;
            }

            resultsList.innerHTML = hotels.map(function (hotel, index) {
                return `
                    <li
                        class="px-4 py-3 text-sm cursor-pointer hover:bg-amber-50 hover:text-amber-900 border-b border-gray-100 last:border-b-0"
                        data-hotel-option
                        data-index="${index}"
                        data-id="${hotel.id}"
                        data-label="${escapeHtml(hotel.name)} (${escapeHtml(hotel.pms_code)})"
                    >
                        <span class="font-medium">${escapeHtml(hotel.name)}</span>
                        <span class="text-gray-500"> (${escapeHtml(hotel.pms_code)})</span>
                    </li>
                `;
            }).join('');

            openResults();
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function selectHotel(id, label) {
            hiddenInput.value = id;
            searchInput.value = label;
            closeResults();

            if (root.dataset.autoSubmit === 'true') {
                const form = root.closest('form');
                if (form) {
                    form.requestSubmit();
                }
            }
        }

        function fetchHotels(search) {
            const url = new URL(apiUrl, window.location.origin);
            if (search) {
                url.searchParams.set('search', search);
            }

            fetch(url.toString(), {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    renderResults(data);
                })
                .catch(function () {
                    resultsList.innerHTML = '<li class="px-4 py-3 text-sm text-red-600">Failed to load hotels</li>';
                    openResults();
                });
        }

        searchInput.addEventListener('focus', function () {
            fetchHotels(searchInput.value.trim());
        });

        searchInput.addEventListener('input', function () {
            hiddenInput.value = '';
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                fetchHotels(searchInput.value.trim());
            }, 250);
        });

        searchInput.addEventListener('keydown', function (event) {
            const options = resultsList.querySelectorAll('[data-hotel-option]');

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                if (options.length === 0) {
                    return;
                }
                activeIndex = Math.min(activeIndex + 1, options.length - 1);
                highlightOption(options);
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                if (options.length === 0) {
                    return;
                }
                activeIndex = Math.max(activeIndex - 1, 0);
                highlightOption(options);
            } else if (event.key === 'Enter') {
                if (activeIndex >= 0 && options[activeIndex]) {
                    event.preventDefault();
                    const option = options[activeIndex];
                    selectHotel(option.dataset.id, option.dataset.label);
                }
            } else if (event.key === 'Escape') {
                closeResults();
            }
        });

        function highlightOption(options) {
            options.forEach(function (option, index) {
                option.classList.toggle('bg-amber-50', index === activeIndex);
                option.classList.toggle('text-amber-900', index === activeIndex);
            });
        }

        resultsList.addEventListener('click', function (event) {
            const option = event.target.closest('[data-hotel-option]');
            if (!option) {
                return;
            }

            selectHotel(option.dataset.id, option.dataset.label);
        });

        document.addEventListener('click', function (event) {
            if (!root.contains(event.target)) {
                closeResults();
            }
        });
    });
}

export function initLiveHotelIndexSearch() {
    const form = document.querySelector('[data-live-hotel-search-form]');
    const resultsContainer = document.querySelector('[data-live-hotel-search-results]');

    if (!form || !resultsContainer) {
        return;
    }

    let debounceTimer = null;

    function runSearch() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        const url = `${form.action}?${params.toString()}`;

        resultsContainer.classList.add('opacity-60');

        fetch(url, {
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
                resultsContainer.classList.remove('opacity-60');
            })
            .catch(function () {
                resultsContainer.classList.remove('opacity-60');
            });
    }

    form.querySelectorAll('[data-live-search-trigger]').forEach(function (input) {
        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(runSearch, 300);
        });

        input.addEventListener('change', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(runSearch, 100);
        });
    });

    resultsContainer.addEventListener('click', function (event) {
        const paginationLink = event.target.closest('#hotels-pagination a');
        if (!paginationLink) {
            return;
        }

        event.preventDefault();
        const url = paginationLink.href;

        resultsContainer.classList.add('opacity-60');

        fetch(url, {
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
                resultsContainer.classList.remove('opacity-60');
            });
    });
}
