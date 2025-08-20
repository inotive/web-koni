@php
    $inputId = $name;
    $previewId = $name . 'PreviewContainer';
    $counterId = $name . 'Counter';
    $warningId = $name . 'MaxWarning';
    $existingInputId = 'existing' . ucfirst(str_replace('_', '', $name)) . 'Input';
    $existingContainerId = 'existing' . ucfirst(str_replace('_', '', $name)) . 'Container';

    $defaultAccept = $type === 'image' ? 'image/*' : '.pdf,.doc,.docx,.xls,.xlsx';
    $acceptAttr = $accept ?? $defaultAccept;

    $defaultHint = $type === 'image'
        ? "Maksimal {$maxFiles} file foto, masing-masing hingga {$maxSize} MB"
        : "Maksimal {$maxFiles} file PDF/Office, masing-masing hingga {$maxSize} MB";
    $hintText = $hint ?? $defaultHint;
@endphp

@php
    if (!function_exists('getFileIcon')) {
        function getFileIcon($extension) {
            $icons = [
                'pdf' => 'fas fa-file-pdf',
                'doc' => 'fas fa-file-word',
                'docx' => 'fas fa-file-word',
                'xls' => 'fas fa-file-excel',
                'xlsx' => 'fas fa-file-excel',
                'ppt' => 'fas fa-file-powerpoint',
                'pptx' => 'fas fa-file-powerpoint'
            ];
            return $icons[strtolower($extension)] ?? 'fas fa-file';
        }
    }
    if (!function_exists('getFileColor')) {
        function getFileColor($extension) {
            $colors = [
                'pdf' => 'text-danger',
                'doc' => 'text-primary',
                'docx' => 'text-primary',
                'xls' => 'text-success',
                'xlsx' => 'text-success',
                'ppt' => 'text-warning',
                'pptx' => 'text-warning'
            ];
            return $colors[strtolower($extension)] ?? 'text-muted';
        }
    }
@endphp

<div class="row align-items-start mb-4">
    <div class="col-md-3">
        <label class="form-label">{{ $label }}</label>
        <p class="file-upload-hint">{{ $hintText }}</p>
    </div>
    <div class="col-md-9">
        @if(count($existingFiles) > 0)
            <div class="current-files">
                <h6>{{ $type === 'image' ? 'Foto' : 'Dokumen' }} saat ini:</h6>
                <div id="{{ $existingContainerId }}">
                    @foreach($existingFiles as $index => $file)
                        @php
                            $extension = pathinfo($file, PATHINFO_EXTENSION);
                        @endphp
                        <div class="existing-file-item" data-type="{{ $name }}" data-index="{{ $index }}">
                            @if($type === 'image')
                                <img src="{{ asset('storage/' . $file) }}" class="existing-preview-image" alt="Current Image">
                            @else
                                <div class="existing-file-icon">
                                    <i class="{{ getFileIcon($extension) }} {{ getFileColor($extension) }}"></i>
                                </div>
                            @endif
                            <div class="file-info">
                                <div class="file-name">{{ basename($file) }}</div>
                                <div class="file-size">File saat ini</div>
                            </div>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="remove-file" onclick="removeExistingFile('{{ $name }}', {{ $index }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="existing_{{ $name }}" id="{{ $existingInputId }}" value="{{ json_encode($existingFiles) }}">
            </div>
        @endif

        <label for="{{ $inputId }}" class="file-upload-wrapper">
            <input type="file" name="{{ $name }}[]" id="{{ $inputId }}"
                class="@error($name) is-invalid @enderror"
                accept="{{ $acceptAttr }}" multiple>

            <div class="d-flex align-items-center gap-12">
                <div class="file-upload-icon-wrapper">
                    <i class="fas fa-upload file-upload-icon"></i>
                </div>
                <div>
                    <p class="file-upload-text" id="{{ $name }}-file-name-display">
                        Seret dan lepas {{ $type === 'image' ? 'foto' : 'dokumen' }} baru di sini, atau klik untuk mengunggah.
                    </p>
                </div>
            </div>
        </label>

        <div id="{{ $previewId }}" class="preview-container" style="display: none;"></div>
        <div id="{{ $counterId }}" class="file-counter"></div>
        <div id="{{ $warningId }}" class="max-files-warning" style="display: none;">
            Maksimal {{ $maxFiles }} {{ $type === 'image' ? 'foto' : 'dokumen' }} yang dapat diunggah.
        </div>

        @error($name)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
