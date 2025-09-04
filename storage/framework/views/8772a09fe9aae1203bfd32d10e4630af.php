<?php if (! $__env->hasRenderedOnce('6a280c83-dd22-4f6d-8bc9-5763652fb74c')): $__env->markAsRenderedOnce('6a280c83-dd22-4f6d-8bc9-5763652fb74c'); ?>
<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    window.initFileUpload = function(config) {
        const {
            name,
            type,
            maxFiles = 10,
            maxSize = 10 * 1024 * 1024,
            existingFiles = []
        } = config;

        let selectedFiles = [];
        let currentExistingFiles = [...existingFiles];

        const input = document.getElementById(name);
        const previewContainer = document.getElementById(name + 'PreviewContainer');
        const nameDisplay = document.getElementById(name + '-file-name-display');
        const counter = document.getElementById(name + 'Counter');
        const maxWarning = document.getElementById(name + 'MaxWarning');

        if (!input) return;

        input.addEventListener('change', function() {
            handleFileSelection(this.files);
        });

        function handleFileSelection(files) {
            const newFiles = Array.from(files).filter(file => {
                if (file.size > maxSize) {
                    alert(`File "${file.name}" terlalu besar. Maksimal ${maxSize/(1024*1024)}MB per file.`);
                    return false;
                }

                if (type === 'image' && !file.type.match('image.*')) {
                    alert(`File "${file.name}" bukan file gambar yang valid.`);
                    return false;
                }

                return true;
            });

            const totalFiles = currentExistingFiles.length + selectedFiles.length + newFiles.length;
            if (totalFiles > maxFiles) {
                alert(`Maksimal ${maxFiles} file dapat diunggah. Anda sudah memiliki ${currentExistingFiles.length + selectedFiles.length} file.`);
                return;
            }

            selectedFiles = [...selectedFiles, ...newFiles];
            updateFilePreview();
            updateFileInput();
            updateFileCounter();
        }

        function updateFilePreview() {
            if (selectedFiles.length === 0) {
                previewContainer.style.display = 'none';
                nameDisplay.textContent = `Seret dan lepas ${type === 'image' ? 'foto' : 'dokumen'} baru di sini, atau klik untuk mengunggah.`;
                return;
            }

            previewContainer.style.display = 'block';
            nameDisplay.textContent = `${selectedFiles.length} file baru dipilih`;

            let previewHTML = '';
            selectedFiles.forEach((file, index) => {
                const fileSize = formatFileSize(file.size);

                if (type === 'image') {
                    const imageUrl = URL.createObjectURL(file);
                    previewHTML += `
                        <div class="file-preview-item" data-index="${index}">
                            <img src="${imageUrl}" alt="Preview" class="preview-image">
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${fileSize}</div>
                            </div>
                            <button type="button" class="remove-file" onclick="removeNewFile(${index}, '${name}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                } else {
                    const extension = file.name.split('.').pop().toLowerCase();
                    const iconClass = getFileIcon(extension);
                    const colorClass = getFileColor(extension);

                    previewHTML += `
                        <div class="file-preview-item" data-index="${index}">
                            <div class="file-icon">
                                <i class="${iconClass} ${colorClass} fs-4"></i>
                            </div>
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${fileSize}</div>
                            </div>
                            <button type="button" class="remove-file" onclick="removeNewFile(${index}, '${name}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                }
            });

            previewContainer.innerHTML = previewHTML;
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => {
                dt.items.add(file);
            });
            input.files = dt.files;
        }

        function updateFileCounter() {
            const totalFiles = currentExistingFiles.length + selectedFiles.length;

            if (totalFiles > 0) {
                counter.textContent = `Total: ${totalFiles}/${maxFiles} file (${currentExistingFiles.length} lama + ${selectedFiles.length} baru)`;
            } else {
                counter.textContent = '';
            }

            if (totalFiles >= maxFiles) {
                maxWarning.style.display = 'block';
            } else {
                maxWarning.style.display = 'none';
            }
        }

        // Store functions globally for this instance
        window[`removeNewFile_${name}`] = function(index) {
            if (type === 'image') {
                const file = selectedFiles[index];
                if (file) {
                    const imgElements = previewContainer.querySelectorAll('.preview-image');
                    imgElements.forEach(img => {
                        if (img.src && img.src.startsWith('blob:')) {
                            URL.revokeObjectURL(img.src);
                        }
                    });
                }
            }
            selectedFiles.splice(index, 1);
            updateFilePreview();
            updateFileInput();
            updateFileCounter();
        };

        window[`removeExistingFile_${name}`] = function(index) {
            currentExistingFiles.splice(index, 1);
            const existingInput = document.getElementById(`existing${name.charAt(0).toUpperCase() + name.slice(1).replace('_', '')}Input`);
            if (existingInput) {
                existingInput.value = JSON.stringify(currentExistingFiles);
            }

            const container = document.getElementById(`existing${name.charAt(0).toUpperCase() + name.slice(1).replace('_', '')}Container`);
            if (container) {
                const items = container.querySelectorAll(`[data-type="${name}"]`);
                items.forEach((item, idx) => {
                    if (idx === index) {
                        item.remove();
                    } else if (idx > index) {
                        item.setAttribute('data-index', idx - 1);
                        const removeBtn = item.querySelector('.remove-file');
                        if (removeBtn) {
                            removeBtn.setAttribute('onclick', `removeExistingFile('${name}', ${idx - 1})`);
                        }
                    }
                });

                if (currentExistingFiles.length === 0) {
                    const currentFilesDiv = container.closest('.current-files');
                    if (currentFilesDiv) {
                        currentFilesDiv.style.display = 'none';
                    }
                }
            }

            updateFileCounter();
        };

        updateFileCounter();

        return {
            removeNewFile: window[`removeNewFile_${name}`],
            removeExistingFile: window[`removeExistingFile_${name}`]
        };
    };

    function formatFileSize(bytes) {
        const units = ['B', 'KB', 'MB', 'GB'];
        let size = bytes;
        let unitIndex = 0;

        while (size >= 1024 && unitIndex < units.length - 1) {
            size /= 1024;
            unitIndex++;
        }

        return size.toFixed(1) + ' ' + units[unitIndex];
    }

    function getFileIcon(extension) {
        const icons = {
            'pdf': 'fas fa-file-pdf',
            'doc': 'fas fa-file-word',
            'docx': 'fas fa-file-word',
            'xls': 'fas fa-file-excel',
            'xlsx': 'fas fa-file-excel',
            'ppt': 'fas fa-file-powerpoint',
            'pptx': 'fas fa-file-powerpoint'
        };
        return icons[extension] || 'fas fa-file';
    }

    function getFileColor(extension) {
        const colors = {
            'pdf': 'text-danger',
            'doc': 'text-primary',
            'docx': 'text-primary',
            'xls': 'text-success',
            'xlsx': 'text-success',
            'ppt': 'text-warning',
            'pptx': 'text-warning'
        };
        return colors[extension] || 'text-muted';
    }

    // Global functions for onclick handlers
    window.removeNewFile = function(index, fieldName) {
        if (window[`removeNewFile_${fieldName}`]) {
            window[`removeNewFile_${fieldName}`](index);
        }
    };

    window.removeExistingFile = function(fieldName, index) {
        if (window[`removeExistingFile_${fieldName}`]) {
            window[`removeExistingFile_${fieldName}`](index);
        }
    };
});
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\ThinkPad\OneDrive\Dokumen\GitHub\web-koni\resources\views/admin/laporan-lpj/bidang/prestasi/beladiri/IBCA/components/file-upload-scripts.blade.php ENDPATH**/ ?>