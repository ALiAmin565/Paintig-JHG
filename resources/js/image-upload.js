export function initImageUpload() {
    const uploadComponents = document.querySelectorAll('[data-image-upload]');
    
    uploadComponents.forEach(component => {
        new ImageUpload(component);
    });
}

class ImageUpload {
    constructor(element) {
        this.element = element;
        this.input = element.querySelector('[data-image-input]');
        this.dropzone = element.querySelector('[data-dropzone]');
        this.uploadContent = element.querySelector('[data-upload-content]');
        this.previewArea = element.querySelector('[data-preview-area]');
        this.previewImage = element.querySelector('[data-preview-image]');
        this.previewFilename = element.querySelector('[data-preview-filename]');
        this.previewSize = element.querySelector('[data-preview-size]');
        this.browseBtn = element.querySelector('[data-browse-btn]');
        this.changeBtn = element.querySelector('[data-change-btn]');
        this.deleteBtn = element.querySelector('[data-delete-btn]');
        this.loading = element.querySelector('[data-loading]');
        
        this.maxFileSize = 5 * 1024 * 1024; // 5MB
        this.acceptedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.setupPasteListener();
    }
    
    bindEvents() {
        // File input change
        this.input.addEventListener('change', (e) => {
            this.handleFiles(e.target.files);
        });
        
        // Browse button click
        this.browseBtn?.addEventListener('click', () => {
            this.input.click();
        });
        
        // Change button click
        this.changeBtn?.addEventListener('click', () => {
            this.input.click();
        });
        
        // Delete button click
        this.deleteBtn?.addEventListener('click', () => {
            this.clearImage();
        });
        
        // Drag and drop events
        this.dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.addDragoverState();
        });
        
        this.dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            if (!this.dropzone.contains(e.relatedTarget)) {
                this.removeDragoverState();
            }
        });
        
        this.dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            this.removeDragoverState();
            this.handleFiles(e.dataTransfer.files);
        });
        
        // Click to upload when no preview
        this.dropzone.addEventListener('click', (e) => {
            if (this.previewArea.classList.contains('hidden') && !this.browseBtn.contains(e.target)) {
                this.input.click();
            }
        });
    }
    
    setupPasteListener() {
        // Add paste listener to document
        document.addEventListener('paste', (e) => {
            // Only handle paste if this upload component is focused or has focus within it
            if (this.element.contains(document.activeElement) || document.activeElement === document.body) {
                this.handlePaste(e);
            }
        });
        
        // Make the dropzone focusable for paste events
        this.dropzone.setAttribute('tabindex', '0');
        this.dropzone.style.outline = 'none';
        
        // Show focus state
        this.dropzone.addEventListener('focus', () => {
            this.dropzone.classList.add('ring-2', 'ring-amber-500/50');
        });
        
        this.dropzone.addEventListener('blur', () => {
            this.dropzone.classList.remove('ring-2', 'ring-amber-500/50');
        });
        
        // Add keyboard support
        this.dropzone.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.input.click();
            }
        });
    }
    
    handlePaste(e) {
        const items = Array.from(e.clipboardData.items);
        const imageItem = items.find(item => item.type.startsWith('image/'));
        
        if (imageItem) {
            e.preventDefault();
            const file = imageItem.getAsFile();
            if (file) {
                this.handleFiles([file]);
            }
        }
    }
    
    addDragoverState() {
        this.element.classList.add('image-upload--dragover');
        this.dropzone.classList.add('image-upload__dropzone--dragover');
    }
    
    removeDragoverState() {
        this.element.classList.remove('image-upload--dragover');
        this.dropzone.classList.remove('image-upload__dropzone--dragover');
    }
    
    handleFiles(files) {
        if (!files || files.length === 0) return;
        
        const file = files[0];
        
        // Validate file type
        if (!this.acceptedTypes.includes(file.type)) {
            this.showError('Please select a valid image file (JPEG, PNG, or WebP).');
            return;
        }
        
        // Validate file size
        if (file.size > this.maxFileSize) {
            this.showError('File size must be less than 5MB.');
            return;
        }
        
        this.clearError();
        this.showLoading();
        
        // Create a new File object for the input
        const dt = new DataTransfer();
        dt.items.add(file);
        this.input.files = dt.files;
        
        // Create preview
        this.createPreview(file);
    }
    
    createPreview(file) {
        const reader = new FileReader();
        
        reader.onload = (e) => {
            this.previewImage.src = e.target.result;
            this.previewFilename.textContent = file.name;
            this.previewSize.textContent = this.formatFileSize(file.size);
            
            this.showPreview();
            this.hideLoading();
        };
        
        reader.onerror = () => {
            this.showError('Error reading file. Please try again.');
            this.hideLoading();
        };
        
        reader.readAsDataURL(file);
    }
    
    showPreview() {
        this.uploadContent.classList.add('hidden');
        this.previewArea.classList.remove('hidden');
    }
    
    hidePreview() {
        this.previewArea.classList.add('hidden');
        this.uploadContent.classList.remove('hidden');
    }
    
    showLoading() {
        this.loading.classList.remove('hidden');
        this.uploadContent.classList.add('hidden');
        this.previewArea.classList.add('hidden');
    }
    
    hideLoading() {
        this.loading.classList.add('hidden');
    }
    
    clearImage() {
        // Clear the file input
        this.input.value = '';
        
        // Clear preview
        this.previewImage.src = '';
        this.previewFilename.textContent = '';
        this.previewSize.textContent = '';
        
        // Show upload area
        this.hidePreview();
        this.clearError();
    }
    
    showError(message) {
        this.clearError();
        
        const errorElement = document.createElement('p');
        errorElement.className = 'image-upload__error';
        errorElement.textContent = message;
        
        this.element.appendChild(errorElement);
        
        // Auto-hide error after 5 seconds
        setTimeout(() => {
            this.clearError();
        }, 5000);
    }
    
    clearError() {
        const existingError = this.element.querySelector('.image-upload__error:not([data-server-error])');
        if (existingError) {
            existingError.remove();
        }
    }
    
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initImageUpload);