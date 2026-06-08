import { initLiveHotelIndexSearch, initSearchableHotelSelects } from './hotel-search';

document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');
    const backdrop = document.getElementById('mobileMenuBackdrop');
    const body = document.body;

    if (mobileMenuToggle && navMenu) {
        function lockBodyScroll() {
            body.style.overflow = 'hidden';
            body.style.position = 'fixed';
            body.style.width = '100%';
        }

        function unlockBodyScroll() {
            body.style.overflow = '';
            body.style.position = '';
            body.style.width = '';
        }

        function openMenu() {
            navMenu.classList.remove('hidden');
            if (backdrop) {
                backdrop.classList.remove('hidden');
            }
            lockBodyScroll();
        }

        function closeMenu() {
            navMenu.classList.add('hidden');
            if (backdrop) {
                backdrop.classList.add('hidden');
            }
            unlockBodyScroll();
        }

        mobileMenuToggle.addEventListener('click', function () {
            if (navMenu.classList.contains('hidden')) {
                openMenu();
            } else {
                closeMenu();
            }
        });

        if (backdrop) {
            backdrop.addEventListener('click', closeMenu);
        }

        navMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !navMenu.classList.contains('hidden')) {
                closeMenu();
            }
        });
    }

    initSearchableHotelSelects();
    initLiveHotelIndexSearch();
});
