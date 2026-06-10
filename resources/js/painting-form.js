export function initPaintingForm() {
    const form = document.querySelector('[data-painting-form]');
    if (!form) {
        return;
    }

    const locationTypeInputs = form.querySelectorAll('[data-location-type]');
    const hotelSection = form.querySelector('[data-location-section="hotel"]');
    const locationSection = form.querySelector('[data-location-section="location"]');
    const certificateTypeInputs = form.querySelectorAll('[data-certificate-type]');
    const certificateTextSection = form.querySelector('[data-certificate-section="text"]');
    const certificateFileSection = form.querySelector('[data-certificate-section="file"]');

    function updateLocationSections() {
        const selected = form.querySelector('[data-location-type]:checked')?.value || 'none';

        if (hotelSection) {
            hotelSection.classList.toggle('hidden', selected !== 'hotel');
            hotelSection.querySelectorAll('input, select').forEach(function (input) {
                input.disabled = selected !== 'hotel';
                if (input.dataset.hotelIdInput !== undefined || input.hasAttribute('data-hotel-id-input')) {
                    input.required = selected === 'hotel';
                }
            });
        }

        if (locationSection) {
            locationSection.classList.toggle('hidden', selected !== 'location');
            locationSection.querySelectorAll('input, select').forEach(function (input) {
                input.disabled = selected !== 'location';
                if (input.hasAttribute('data-location-id-input')) {
                    input.required = selected === 'location';
                }
            });
        }
    }

    function updateCertificateSections() {
        const selected = form.querySelector('[data-certificate-type]:checked')?.value || 'text';

        if (certificateTextSection) {
            certificateTextSection.classList.toggle('hidden', selected !== 'text');
        }

        if (certificateFileSection) {
            certificateFileSection.classList.toggle('hidden', selected !== 'file');
        }
    }

    locationTypeInputs.forEach(function (input) {
        input.addEventListener('change', updateLocationSections);
    });

    certificateTypeInputs.forEach(function (input) {
        input.addEventListener('change', updateCertificateSections);
    });

    updateLocationSections();
    updateCertificateSections();
}
