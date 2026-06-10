export function initSearchableLocationSelects() {
    document.querySelectorAll('[data-searchable-location-select]').forEach(function (root) {
        if (root.dataset.initialized === 'true') {
            return;
        }

        root.dataset.initialized = 'true';

        const apiUrl = root.dataset.apiUrl;
        const createUrl = root.dataset.createUrl;
        const allowCreate = root.dataset.allowCreate === 'true';
        const hiddenInput = root.querySelector('[data-location-id-input]');
        const newLocationInput = root.querySelector('[data-new-location-name-input]');
        const searchInput = root.querySelector('[data-location-search-input]');
        const resultsList = root.querySelector('[data-location-search-results]');

        let debounceTimer = null;
        let activeIndex = -1;
        let currentResults = [];
        let currentSearch = '';

        function closeResults() {
            resultsList.classList.add('hidden');
            activeIndex = -1;
        }

        function openResults() {
            resultsList.classList.remove('hidden');
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function selectLocation(id, label) {
            hiddenInput.value = id;
            if (newLocationInput) {
                newLocationInput.value = '';
            }
            searchInput.value = label;
            closeResults();

            if (root.dataset.autoSubmit === 'true') {
                const form = root.closest('form');
                if (form) {
                    form.requestSubmit();
                }
            }

            if (root.dataset.liveFilter === 'true') {
                const form = root.closest('form');
                if (form) {
                    form.dispatchEvent(new CustomEvent('live-filter-change', { bubbles: true }));
                }
            }
        }

        function triggerLiveFilter() {
            if (root.dataset.liveFilter !== 'true') {
                return;
            }

            const form = root.closest('form');
            if (form) {
                form.dispatchEvent(new CustomEvent('live-filter-change', { bubbles: true }));
            }
        }

        function renderResults(locations, search) {
            currentSearch = search;
            currentResults = locations;
            activeIndex = -1;

            let html = locations.map(function (location, index) {
                return `
                    <li
                        class="px-4 py-3 text-sm cursor-pointer hover:bg-amber-50 hover:text-amber-900 border-b border-gray-100 last:border-b-0"
                        data-location-option
                        data-index="${index}"
                        data-id="${location.id}"
                        data-label="${escapeHtml(location.name)}"
                    >
                        <span class="font-medium">${escapeHtml(location.name)}</span>
                        ${location.description ? `<span class="block text-xs text-gray-500 mt-0.5">${escapeHtml(location.description)}</span>` : ''}
                    </li>
                `;
            }).join('');

            if (allowCreate && search.trim().length > 0) {
                const exactMatch = locations.some(function (location) {
                    return location.name.toLowerCase() === search.trim().toLowerCase();
                });

                if (!exactMatch) {
                    html += `
                        <li
                            class="px-4 py-3 text-sm cursor-pointer bg-amber-50 text-amber-900 border-t border-amber-100 font-medium"
                            data-create-location
                            data-name="${escapeHtml(search.trim())}"
                        >
                            Create "${escapeHtml(search.trim())}"
                        </li>
                    `;
                }
            }

            if (!html) {
                html = '<li class="px-4 py-3 text-sm text-gray-500">No locations found</li>';
            }

            resultsList.innerHTML = html;
            openResults();
        }

        function fetchLocations(search) {
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
                    renderResults(data, search);
                })
                .catch(function () {
                    resultsList.innerHTML = '<li class="px-4 py-3 text-sm text-red-600">Failed to load locations</li>';
                    openResults();
                });
        }

        function createLocation(name) {
            fetch(createUrl, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ name: name }),
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Failed to create location');
                    }
                    return response.json();
                })
                .then(function (location) {
                    selectLocation(location.id, location.name);
                })
                .catch(function () {
                    if (newLocationInput) {
                        hiddenInput.value = '';
                        newLocationInput.value = name;
                        searchInput.value = name;
                    }
                    closeResults();
                });
        }

        searchInput.addEventListener('focus', function () {
            fetchLocations(searchInput.value.trim());
        });

        searchInput.addEventListener('input', function () {
            hiddenInput.value = '';
            if (newLocationInput) {
                newLocationInput.value = '';
            }
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                fetchLocations(searchInput.value.trim());
                triggerLiveFilter();
            }, 250);
        });

        searchInput.addEventListener('keydown', function (event) {
            const options = resultsList.querySelectorAll('[data-location-option]');

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
                    selectLocation(option.dataset.id, option.dataset.label);
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
            const createOption = event.target.closest('[data-create-location]');
            if (createOption) {
                createLocation(createOption.dataset.name);
                return;
            }

            const option = event.target.closest('[data-location-option]');
            if (!option) {
                return;
            }

            selectLocation(option.dataset.id, option.dataset.label);
        });

        document.addEventListener('click', function (event) {
            if (!root.contains(event.target)) {
                closeResults();
            }
        });
    });
}
