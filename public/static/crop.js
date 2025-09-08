/**
 * Auto Crop Image Handler
 * @author GemPixel
 */
class AutoCropHandler {
    constructor() {
        this.cropper = null;
        this.currentFile = null;
        this.currentInput = null;
                
        this.cleanupBackdrops();
        
        this.init();
    }
    
    /**
     * Clean up any existing modal backdrops
     */
    cleanupBackdrops() {
        const existingBackdrops = document.querySelectorAll('.modal-backdrop');
        existingBackdrops.forEach(backdrop => backdrop.remove());
    }

    init() {        
        const autoCropInputs = document.querySelectorAll('input[type="file"][data-auto-crop]');
        
        autoCropInputs.forEach(input => {
            input.addEventListener('change', (e) => this.handleFileChange(e));
        });
        
        this.initModalEvents();
    }

    /**
     * Handle file input change
     */
    handleFileChange(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (!this.validateFile(file, e.target)) {            
            return;
        }

        this.currentFile = file;
        this.currentInput = e.target;
                
        this.loadImageForCropping(file);
    }

    /**
     * Validate uploaded file
     */
    validateFile(file, input) {        
        const allowedExtensions = input.dataset.allowedExtensions || 'jpg,jpeg,png,gif';
        const allowedTypes = allowedExtensions.split(',').map(ext => ext.trim().toLowerCase());
        const maxSize = input.dataset.maxSize || 1024;
        const error = input.dataset.error;        
        
        if (file.size > maxSize * 1024) {
            $.notify({
                message: error
            },{
                type: 'danger',
                placement: {
                    from: "top",
                    align: "right"
                },
            });
            return false;
        }
        
        const fileExtension = file.name.split('.').pop().toLowerCase();  
                
        if (fileExtension === 'svg' || fileExtension === 'webp') {
            $.notify({
                message: 'SVG and WebP files cannot be cropped. Please use JPG, PNG, or GIF files.'
            },{
                type: 'warning',
                placement: {
                    from: "top",
                    align: "right"
                },
            });
            return false;
        }
        
        if (!allowedTypes.includes(fileExtension)) {
            $.notify({
                message: error
            },{
                type: 'danger',
                placement: {
                    from: "top",
                    align: "right"
                },
            });
            return false;
        }
        
        if (!file.type.startsWith('image/')) {
            $.notify({
                message: error
            },{
                type: 'danger',
                placement: {
                    from: "top",
                    align: "right"
                },
            });
            return false;
        }

        return true;
    }

    /**
     * Load image for cropping
     */
    loadImageForCropping(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const cropperImage = document.getElementById('cropper-image');
            if (cropperImage) {
                cropperImage.src = e.target.result;
                this.openCropperModal();
            }
        };
        reader.readAsDataURL(file);
    }

    /**
     * Open cropper modal
     */
    openCropperModal() {
        const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
        modal.show();
                
        setTimeout(() => this.initCropper(), 300);
    }

    /**
     * Initialize cropper instance
     */
    initCropper() {
        const image = document.getElementById('cropper-image');
        if (!image) return;
        
        if (this.cropper) {
            this.cropper.destroy();
        }
        
        this.cropper = new Cropper(image, {
            aspectRatio: this.currentInput.dataset.ratio ? parseInt(this.currentInput.dataset.ratio.split(':')[0]) / parseInt(this.currentInput.dataset.ratio.split(':')[1]) : 1,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
            ready: () => {                                
            }
        });
    }

    /**
     * Save cropped image
     */
    saveCroppedImage() {
        if (!this.cropper || !this.currentFile || !this.currentInput) {
            this.showError('No image to crop');
            return;
        }

        try {            
            const image = document.getElementById('cropper-image');
            const originalWidth = image.naturalWidth;
            const originalHeight = image.naturalHeight;
            
            const canvas = this.cropper.getCroppedCanvas({
                width: originalWidth,
                height: originalHeight,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            
            canvas.toBlob((blob) => {
                this.processCroppedBlob(blob);
            }, 'image/jpeg', 0.9);

        } catch (error) {            
            this.showError('Error processing image. Please try again.');
        }
    }

    /**
     * Process cropped blob
     */
    processCroppedBlob(blob) {
        try {            
            const originalName = this.currentFile.name;
            const nameWithoutExt = originalName.substring(0, originalName.lastIndexOf('.'));
            const extension = originalName.substring(originalName.lastIndexOf('.'));
            const croppedFileName = `${nameWithoutExt}_cropped${extension}`;
            
            const croppedFile = new File([blob], croppedFileName, { 
                type: this.currentFile.type 
            });
            
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            this.currentInput.files = dataTransfer.files;
            
            $(this.currentInput).trigger('change');
            this.updatePreview(blob);
            
            this.closeCropperModal();
            
            this.showSuccess('Image cropped successfully!');

        } catch (error) {            
            this.showError('Error saving cropped image');
        }
    }

    /**
     * Update image preview
     */
    updatePreview(blob) {
        const previewSelector = this.currentInput.dataset.previewSelector;
        if (previewSelector) {
            const previewElement = document.querySelector(previewSelector);
            if (previewElement) {
                previewElement.src = URL.createObjectURL(blob);
            }
        }
    }

    /**
     * Close cropper modal
     */
    closeCropperModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('cropperModal'));
        if (modal) {
            modal.hide();
        }
                
        setTimeout(() => {
            const existingBackdrops = document.querySelectorAll('.modal-backdrop');
            existingBackdrops.forEach(backdrop => backdrop.remove());
        }, 150);
        
        this.currentFile = null;
        this.currentInput = null;
    }

    /**
     * Initialize modal events
     */
    initModalEvents() {        
        const saveButton = document.getElementById('crop-save');
        if (saveButton) {
            saveButton.addEventListener('click', () => this.saveCroppedImage());
        }
        
        const modal = document.getElementById('cropperModal');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', () => {
                if (this.cropper) {
                    this.cropper.destroy();
                    this.cropper = null;
                }
                                
                const existingBackdrops = document.querySelectorAll('.modal-backdrop');
                existingBackdrops.forEach(backdrop => backdrop.remove());
                
                this.currentFile = null;
                this.currentInput = null;
            });
        }
    }

    /**
     * Show error message
     */
    showError(message) {                
    }

    /**
     * Show success message
     */
    showSuccess(message) {                
    }
}

document.addEventListener('DOMContentLoaded', function() {
    new AutoCropHandler();
});

window.cleanupModalBackdrops = function() {
    const existingBackdrops = document.querySelectorAll('.modal-backdrop');
    existingBackdrops.forEach(backdrop => backdrop.remove());
};