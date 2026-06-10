export function initSearchableGallerySelects() {
    document.querySelectorAll('[data-searchable-gallery-select]').forEach(function (root) {
        if (root.dataset.initialized === 'true') {
            return;
        }

        root.dataset.initialized = 'true';

        const apiUrl = root.dataset.apiUrl;
        const createUrl = root.dataset.createUrl;
        const allowCreate = root.dataset.allowCreate === 'true';
        const hiddenInput = root.querySelector('[data-gallery-id-input]');
        const newGalleryInput = root.querySelector('[data-new-gallery-name-input]');
        const searchInput = root.querySelector('[data-gallery-search-input]');
        const resultsList = root.querySelector('[data-gallery-search-results]');

        let debounceTimer = null;
        let activeIndex = -1;

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

        function selectGallery(id, label) {
            hiddenInput.value = id;
            if (newGalleryInput) {
                newGalleryInput.value = '';
            }
            searchInput.value = label;
            closeResults();
        }

        function renderResults(galleries, search) {
            activeIndex = -1;

            let html = galleries.map(function (gallery, index) {
                return `
                    <li
                        class="px-4 py-3 text-sm cursor-pointer hover:bg-amber-50 hover:text-amber-900 border-b border-gray-100 last:border-b-0"
                        data-gallery-option
                        data-index="${index}"
                        data-id="${gallery.id}"
                        data-label="${escapeHtml(gallery.name)}"
                    >
                        <span class="font-medium">${escapeHtml(gallery.name)}</span>
                        ${gallery.description ? `<span class="block text-xs text-gray-500 mt-0.5">${escapeHtml(gallery.description)}</span>` : ''}
                    </li>
                `;
            }).join('');

            if (allowCreate && search.trim().length > 0) {
                const exactMatch = galleries.some(function (gallery) {
                    return gallery.name.toLowerCase() === search.trim().toLowerCase();
                });

                if (!exactMatch) {
                    html += `
                        <li
                            class="px-4 py-3 text-sm cursor-pointer bg-amber-50 text-amber-900 border-t border-amber-100 font-medium"
                            data-create-gallery
                            data-name="${escapeHtml(search.trim())}"
                        >
                            Create "${escapeHtml(search.trim())}"
                        </li>
                    `;
                }
            }

            if (!html) {
                html = '<li class="px-4 py-3 text-sm text-gray-500">No galleries found</li>';
            }

            resultsList.innerHTML = html;
            openResults();
        }

        function fetchGalleries(search) {
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
                    resultsList.innerHTML = '<li class="px-4 py-3 text-sm text-red-600">Failed to load galleries</li>';
                    openResults();
                });
        }

        function createGallery(name) {
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
                        throw new Error('Failed to create gallery');
                    }
                    return response.json();
                })
                .then(function (gallery) {
                    selectGallery(gallery.id, gallery.name);
                })
                .catch(function () {
                    if (newGalleryInput) {
                        hiddenInput.value = '';
                        newGalleryInput.value = name;
                        searchInput.value = name;
                    }
                    closeResults();
                });
        }

        searchInput.addEventListener('focus', function () {
            fetchGalleries(searchInput.value.trim());
        });

        searchInput.addEventListener('input', function () {
            hiddenInput.value = '';
            if (newGalleryInput) {
                newGalleryInput.value = '';
            }
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                fetchGalleries(searchInput.value.trim());
            }, 250);
        });

        searchInput.addEventListener('keydown', function (event) {
            const options = resultsList.querySelectorAll('[data-gallery-option]');

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
                    selectGallery(option.dataset.id, option.dataset.label);
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
            const createOption = event.target.closest('[data-create-gallery]');
            if (createOption) {
                createGallery(createOption.dataset.name);
                return;
            }

            const option = event.target.closest('[data-gallery-option]');
            if (!option) {
                return;
            }

            selectGallery(option.dataset.id, option.dataset.label);
        });

        document.addEventListener('click', function (event) {
            if (!root.contains(event.target)) {
                closeResults();
            }
        });
    });
}
