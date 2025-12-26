@extends('layouts.app')

@section('title', 'Edit Service Catalog')

@push('styles')
<style>
    /* === VARIABLES & RESET === */
    :root {
        --primary-dark: #080F5C;
        --primary: #334EAC;
        --primary-light: #7086D1;
        --accent-light: #D0D5FF;
        --bg-light: #E7E8FF;
        --bg-white: #F9FAFF;
        --success: #43e97b;
        --danger: #ff6b6b;
    }

    .service-form-page {
        padding: 20px;
        background: var(--bg-white);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* === HEADER SECTION === */
    .page-header {
        margin-bottom: 30px;
        padding: 25px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(8, 15, 92, 0.06);
        border: 1px solid var(--bg-light);
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header-content h1 {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header-content h1::before {
        content: '';
        width: 4px;
        height: 28px;
        background: var(--primary);
        border-radius: 2px;
    }

    .page-header-content p {
        font-size: 14px;
        color: var(--primary);
        opacity: 0.8;
        line-height: 1.5;
    }

    /* === FORM CONTAINER === */
    .form-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid var(--bg-light);
        box-shadow: 0 4px 24px rgba(8, 15, 92, 0.06);
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out 0.2s both;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--bg-light);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-title i {
        color: var(--primary);
        font-size: 22px;
    }

    /* === FORM ELEMENTS === */
    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--primary);
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label.required::after {
        content: " *";
        color: var(--danger);
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-light);
        font-size: 16px;
        pointer-events: none;
        z-index: 1;
    }

    .form-input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border: 2px solid var(--bg-light);
        border-radius: 12px;
        font-size: 15px;
        color: var(--primary-dark);
        background: var(--bg-white);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 500;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-light);
        background: white;
        box-shadow: 0 0 0 3px rgba(112, 134, 209, 0.1);
        transform: translateY(-1px);
    }

    .form-input::placeholder {
        color: var(--primary);
        opacity: 0.4;
        font-weight: 400;
    }

    .form-input.error {
        border-color: var(--danger);
        background: rgba(255, 107, 107, 0.02);
    }

    .character-count {
        text-align: right;
        font-size: 12px;
        color: var(--primary);
        opacity: 0.6;
        margin-top: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .character-count.warning {
        color: var(--danger);
        font-weight: 600;
    }

    .form-help {
        display: block;
        margin-top: 8px;
        font-size: 13px;
        color: var(--primary);
        opacity: 0.6;
        line-height: 1.5;
    }

    /* === ERROR MESSAGES === */
    .alert-error {
        background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInRight 0.4s ease-out;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    @keyframes slideInRight {
        from {
            transform: translateX(-20px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .alert-error i {
        font-size: 18px;
    }

    .error-message {
        color: var(--danger);
        font-size: 13px;
        margin-top: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .error-message i {
        font-size: 14px;
    }

    /* === FORM ACTIONS === */
    .form-actions {
        display: flex;
        gap: 16px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1px solid var(--bg-light);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 28px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        white-space: nowrap;
        flex: 1;
        box-shadow: 0 2px 8px rgba(51, 78, 172, 0.15);
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.25);
    }

    .btn-secondary {
        background: var(--bg-light);
        color: var(--primary);
        border: 1px solid var(--accent-light);
    }

    .btn-secondary:hover {
        background: var(--accent-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(112, 134, 209, 0.2);
    }

    .btn i {
        font-size: 16px;
    }

    /* === LOADING STATE === */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid white;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* === SCROLL TO TOP === */
    .scroll-top {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--primary);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 100;
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.25);
    }

    .scroll-top.visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .scroll-top:hover {
        background: var(--primary-dark);
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 16px rgba(51, 78, 172, 0.35);
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {
        .service-form-page {
            padding: 16px;
        }
        
        .page-header {
            padding: 20px;
        }
        
        .form-container {
            padding: 24px;
        }
        
        .form-title {
            font-size: 18px;
        }
    }

    @media (max-width: 768px) {
        .form-container {
            max-width: 100%;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
        
        .page-header-content h1 {
            font-size: 24px;
        }
    }

    @media (max-width: 576px) {
        .service-form-page {
            padding: 12px;
        }
        
        .page-header {
            padding: 16px;
        }
        
        .form-container {
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-input {
            padding: 12px 16px 12px 48px;
            font-size: 14px;
        }
        
        .btn {
            padding: 12px 20px;
            font-size: 13px;
        }
        
        .page-header-content h1 {
            font-size: 22px;
        }
    }

    /* === ANIMATIONS === */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-group {
        animation: fadeIn 0.5s ease-out;
        animation-fill-mode: backwards;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
</style>
@endpush

@section('content')
<div class="service-form-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>
                <i class="bi bi-pencil-square"></i>
                Edit Service Catalog
            </h1>
            <p>Perbarui informasi service yang sudah ada dalam katalog</p>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert-error">
            <i class="bi bi-exclamation-circle"></i>
            <div>
                <strong>Terjadi kesalahan!</strong>
                <span style="font-size: 13px; opacity: 0.9; display: block; margin-top: 4px;">
                    Mohon periksa kembali form yang diisi.
                </span>
            </div>
        </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-title">
            <i class="bi bi-sliders"></i>
            Form Edit Service
        </div>

        <form action="{{ route('service_catalog.update', $service->id) }}" method="POST" id="serviceForm">
            @csrf
            @method('PUT')
            
            <!-- Service Information -->
            <div class="form-group">
                <label for="category_name" class="form-label required">
                    <i class="bi bi-tag"></i>
                    KATEGORI SERVICE
                </label>
                <div class="input-wrapper">
                    <i class="bi bi-tags input-icon"></i>
                    <input 
                        type="text" 
                        id="category_name" 
                        name="category_name" 
                        class="form-input @error('category_name') error @enderror" 
                        value="{{ old('category_name', $service->category_name) }}"
                        placeholder="Contoh: Cloud Computing, Database, Networking"
                        required
                        maxlength="100"
                        autofocus
                    >
                </div>
                <div class="character-count" id="categoryCount">
                    {{ strlen(old('category_name', $service->category_name)) }}/100 karakter
                </div>
                @error('category_name')
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small class="form-help">
                    Masukkan kategori atau grup service. Contoh: "Cloud Services", "Infrastructure", dll.
                </small>
            </div>

            <div class="form-group">
                <label for="service_name" class="form-label required">
                    <i class="bi bi-gear"></i>
                    NAMA SERVICE
                </label>
                <div class="input-wrapper">
                    <i class="bi bi-server input-icon"></i>
                    <input 
                        type="text" 
                        id="service_name" 
                        name="service_name" 
                        class="form-input @error('service_name') error @enderror" 
                        value="{{ old('service_name', $service->service_name) }}"
                        placeholder="Contoh: Virtual Private Server, Cloud Storage, Database Hosting"
                        required
                        maxlength="150"
                    >
                </div>
                <div class="character-count" id="serviceCount">
                    {{ strlen(old('service_name', $service->service_name)) }}/150 karakter
                </div>
                @error('service_name')
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small class="form-help">
                    Masukkan nama lengkap service yang akan ditawarkan kepada customer.
                </small>
            </div>

            <!-- Service Info (Readonly) -->
            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-info-circle"></i>
                    INFORMASI SERVICE
                </label>
                <div style="
                    background: var(--bg-light);
                    border-radius: 12px;
                    padding: 20px;
                    border: 2px solid var(--accent-light);
                    font-size: 14px;
                    color: var(--primary);
                ">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-weight: 600;">ID Service:</span>
                        <span style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                            #{{ $service->id }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-weight: 600;">Dibuat:</span>
                        <span>{{ $service->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 600;">Terakhir Update:</span>
                        <span>{{ $service->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-check-circle"></i> Update Service
                </button>
                <a href="{{ route('service_catalog.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </form>
    </div>

    <!-- Scroll to top button -->
    <button class="scroll-top" id="scrollTop">
        <i class="bi bi-chevron-up"></i>
    </button>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === CHARACTER COUNTER ===
        const categoryInput = document.getElementById('category_name');
        const serviceInput = document.getElementById('service_name');
        const categoryCount = document.getElementById('categoryCount');
        const serviceCount = document.getElementById('serviceCount');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('serviceForm');

        function updateCharacterCount(inputElement, countElement, maxLength) {
            const currentLength = inputElement.value.length;
            countElement.textContent = `${currentLength}/${maxLength} karakter`;
            
            // Add warning class if near limit
            if (currentLength > maxLength * 0.8) {
                countElement.classList.add('warning');
            } else {
                countElement.classList.remove('warning');
            }
            
            // Validate max length
            if (currentLength > maxLength) {
                inputElement.style.borderColor = 'var(--danger)';
                countElement.style.color = 'var(--danger)';
            } else {
                inputElement.style.borderColor = '';
            }
        }

        // Initialize counters
        updateCharacterCount(categoryInput, categoryCount, 100);
        updateCharacterCount(serviceInput, serviceCount, 150);

        // Add event listeners
        categoryInput.addEventListener('input', () => updateCharacterCount(categoryInput, categoryCount, 100));
        serviceInput.addEventListener('input', () => updateCharacterCount(serviceInput, serviceCount, 150));

        // === FORM VALIDATION ===
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const errors = [];
            
            // Clear previous error states
            document.querySelectorAll('.form-input.error').forEach(input => {
                input.classList.remove('error');
            });

            // Validate category name
            if (!categoryInput.value.trim()) {
                categoryInput.classList.add('error');
                errors.push('Kategori service wajib diisi');
                isValid = false;
            } else if (categoryInput.value.trim().length > 100) {
                categoryInput.classList.add('error');
                errors.push('Kategori maksimal 100 karakter');
                isValid = false;
            }
            
            // Validate service name
            if (!serviceInput.value.trim()) {
                serviceInput.classList.add('error');
                errors.push('Nama service wajib diisi');
                isValid = false;
            } else if (serviceInput.value.trim().length > 150) {
                serviceInput.classList.add('error');
                errors.push('Nama service maksimal 150 karakter');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                
                // Show error notification
                const errorMessage = errors.join('<br>');
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        html: errorMessage,
                        confirmButtonColor: 'var(--primary)',
                        background: 'var(--bg-white)',
                        confirmButtonText: 'Mengerti'
                    });
                } else {
                    alert(errors.join('\n'));
                }
                
                // Scroll to first error
                const firstError = document.querySelector('.form-input.error');
                if (firstError) {
                    firstError.focus();
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                // Show loading state
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '';
            }
        });

        // === SCROLL TO TOP ===
        const scrollTopBtn = document.getElementById('scrollTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        });

        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // === AUTO-SAVE DRAFT (OPTIONAL) ===
        let saveTimeout;
        
        function autoSaveDraft() {
            const formData = {
                category_name: categoryInput.value,
                service_name: serviceInput.value
            };
            
            // Save to localStorage
            localStorage.setItem('service_edit_draft', JSON.stringify(formData));
            console.log('Draft tersimpan:', formData);
        }

        // Save on input with debounce
        [categoryInput, serviceInput].forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(autoSaveDraft, 1000);
            });
        });

        // Load draft on page load (optional feature)
        const savedDraft = localStorage.getItem('service_edit_draft');
        if (savedDraft && confirm('Ada draft yang belum tersimpan. Mau gunakan?')) {
            try {
                const draft = JSON.parse(savedDraft);
                if (draft.category_name) categoryInput.value = draft.category_name;
                if (draft.service_name) serviceInput.value = draft.service_name;
                
                // Update character counts
                updateCharacterCount(categoryInput, categoryCount, 100);
                updateCharacterCount(serviceInput, serviceCount, 150);
                
                // Clear draft after loading
                localStorage.removeItem('service_edit_draft');
            } catch (e) {
                console.error('Error loading draft:', e);
            }
        }

        // Clear draft on successful form submit
        form.addEventListener('submit', function() {
            localStorage.removeItem('service_edit_draft');
        });

        // === KEYBOARD SHORTCUTS ===
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                submitBtn.click();
            }
            
            // Escape to cancel (go back)
            if (e.key === 'Escape') {
                if (confirm('Batalkan edit dan kembali?')) {
                    window.location.href = "{{ route('service_catalog.index') }}";
                }
            }
            
            // Ctrl/Cmd + Enter to submit
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                form.requestSubmit();
            }
        });

        // === INPUT ANIMATIONS ===
        [categoryInput, serviceInput].forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
                this.parentElement.style.boxShadow = '0 4px 12px rgba(112, 134, 209, 0.15)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = '';
                this.parentElement.style.boxShadow = '';
            });
        });
    });
</script>
@endpush