@extends('layouts.app')

@section('title', 'Tambah Service Catalog')

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
        --success: #27ae60;
        --error: #e74c3c;
        --warning: #f39c12;
    }

    .service-form-page {
        padding: 30px;
        max-width: 1200px;
        margin: 0 auto;
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* === HEADER SECTION === */
    .page-header {
        margin-bottom: 30px;
        padding: 25px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(8, 15, 92, 0.06);
        border: 1px solid var(--bg-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-header-content h1 {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 8px;
    }

    .page-header-content p {
        font-size: 14px;
        color: var(--primary);
        opacity: 0.8;
        max-width: 500px;
        line-height: 1.5;
    }

    .btn-primary-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(51, 78, 172, 0.25);
        white-space: nowrap;
    }

    .btn-primary-action:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.35);
        text-decoration: none;
        color: white;
    }

    /* === ALERT === */
    .alert-error {
        background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    /* === FORM CONTAINER === */
    .form-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid var(--bg-light);
        box-shadow: 0 4px 24px rgba(8, 15, 92, 0.06);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .form-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--bg-light);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: var(--primary);
        border-radius: 2px;
    }

    /* === FORM SECTIONS === */
    .form-section {
        margin-bottom: 30px;
        padding: 24px;
        border-radius: 12px;
        background: var(--bg-white);
        border: 1px solid var(--bg-light);
        transition: all 0.3s ease;
    }

    .form-section:hover {
        border-color: var(--accent-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8, 15, 92, 0.08);
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary-light);
        font-size: 18px;
        background: var(--bg-light);
        padding: 8px;
        border-radius: 10px;
    }

    /* === FORM GROUPS === */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label.required::after {
        content: "*";
        color: var(--error);
        font-size: 18px;
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-light);
        font-size: 18px;
        z-index: 1;
    }

    .form-input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border: 2px solid var(--bg-light);
        border-radius: 10px;
        font-size: 14px;
        color: var(--primary-dark);
        background: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: inherit;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-light);
        background: var(--bg-white);
        box-shadow: 0 0 0 3px rgba(112, 134, 209, 0.1);
    }

    .form-input.error {
        border-color: var(--error);
        background: rgba(231, 76, 60, 0.02);
    }

    .form-input.success {
        border-color: var(--success);
        background: rgba(39, 174, 96, 0.02);
    }

    .form-input::placeholder {
        color: var(--primary-light);
        opacity: 0.6;
    }

    /* === HELP TEXT & COUNTERS === */
    .form-help {
        display: block;
        margin-top: 8px;
        font-size: 12px;
        color: var(--primary);
        opacity: 0.6;
        line-height: 1.4;
    }

    .character-count {
        text-align: right;
        font-size: 12px;
        color: var(--primary);
        margin-top: 6px;
        opacity: 0.7;
        font-weight: 500;
    }

    .character-count.warning {
        color: var(--warning);
        font-weight: 600;
    }

    .character-count.error {
        color: var(--error);
        font-weight: 600;
    }

    /* === ERROR MESSAGES === */
    .error-message {
        color: var(--error);
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }

    /* === FORM ACTIONS === */
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid var(--bg-light);
    }

    .btn {
        padding: 14px 28px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-family: inherit;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        box-shadow: 0 2px 8px rgba(51, 78, 172, 0.25);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.35);
        color: white;
    }

    .btn-secondary {
        background: white;
        color: var(--primary);
        border: 2px solid var(--bg-light);
    }

    .btn-secondary:hover {
        background: var(--bg-light);
        border-color: var(--primary-light);
        color: var(--primary-dark);
        transform: translateY(-2px);
    }

    /* === FLOATING LABELS EFFECT === */
    .floating-label {
        position: absolute;
        left: 48px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-light);
        font-size: 14px;
        transition: all 0.3s ease;
        pointer-events: none;
        background: white;
        padding: 0 4px;
    }

    .form-input:focus + .floating-label,
    .form-input:not(:placeholder-shown) + .floating-label {
        top: 0;
        transform: translateY(-50%);
        font-size: 12px;
        color: var(--primary);
        font-weight: 600;
    }

    /* === SUCCESS STATE ANIMATION === */
    @keyframes successPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(39, 174, 96, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(39, 174, 96, 0);
        }
    }

    .success-animation {
        animation: successPulse 0.6s ease-out;
    }

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 768px) {
        .service-form-page {
            padding: 20px;
        }

        .page-header {
            padding: 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header-content h1 {
            font-size: 24px;
        }

        .form-container {
            padding: 20px;
        }

        .form-section {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .service-form-page {
            padding: 16px;
        }

        .form-container {
            padding: 16px;
        }

        .form-input {
            padding: 12px 16px 12px 44px;
        }

        .input-icon {
            left: 14px;
        }

        .page-header-content h1 {
            font-size: 22px;
        }
    }

    /* === SCROLL TO TOP BUTTON === */
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
</style>
@endpush

@section('content')
<div class="service-form-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>Tambah Service Catalog</h1>
            <p>Tambahkan layanan baru ke dalam katalog service</p>
        </div>
        <a href="{{ route('service_catalog.index') }}" class="btn-primary-action">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-title">Form Tambah Service</div>
        
        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert-error">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.</span>
                </div>
                <button class="close-btn" onclick="this.parentElement.style.display='none'">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        @endif

        <form action="{{ route('service_catalog.store') }}" method="POST" id="serviceForm">
            @csrf
            
            <!-- Service Information Section -->
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Informasi Service
                </div>
                
                <!-- Category Field -->
                <div class="form-group">
                    <label for="category_name" class="form-label required">
                        <i class="bi bi-tag"></i>
                        Kategori Service
                    </label>
                    <div class="input-group">
                        <i class="bi bi-tags input-icon"></i>
                        <input 
                            type="text" 
                            id="category_name" 
                            name="category_name" 
                            class="form-input @error('category_name') error @enderror" 
                            value="{{ old('category_name') }}"
                            placeholder=" "
                            required
                            maxlength="100"
                        >
                        <span class="floating-label">Contoh: Cloud Computing, Database, Networking</span>
                    </div>
                    <div class="character-count" id="categoryCount">0/100 karakter</div>
                    @error('category_name')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <div class="form-help">
                        Masukkan kategori atau grup service (contoh: Infrastructure, Software, Support)
                    </div>
                </div>

                <!-- Service Name Field -->
                <div class="form-group">
                    <label for="service_name" class="form-label required">
                        <i class="bi bi-gear"></i>
                        Nama Service
                    </label>
                    <div class="input-group">
                        <i class="bi bi-briefcase input-icon"></i>
                        <input 
                            type="text" 
                            id="service_name" 
                            name="service_name" 
                            class="form-input @error('service_name') error @enderror" 
                            value="{{ old('service_name') }}"
                            placeholder=" "
                            required
                            maxlength="150"
                        >
                        <span class="floating-label">Contoh: Virtual Private Server, Cloud Storage</span>
                    </div>
                    <div class="character-count" id="serviceCount">0/150 karakter</div>
                    @error('service_name')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <div class="form-help">
                        Masukkan nama lengkap service yang akan ditawarkan
                    </div>
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    <label for="description" class="form-label">
                        <i class="bi bi-text-paragraph"></i>
                        Deskripsi Service
                    </label>
                    <div class="input-group">
                        <i class="bi bi-chat-text input-icon"></i>
                        <input 
                            type="text" 
                            id="description" 
                            name="description" 
                            class="form-input @error('description') error @enderror" 
                            value="{{ old('description') }}"
                            placeholder=" "
                            maxlength="500"
                        >
                        <span class="floating-label">Deskripsi singkat tentang service</span>
                    </div>
                    <div class="character-count" id="descriptionCount">0/500 karakter</div>
                    @error('description')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <div class="form-help">
                        Deskripsi opsional untuk memberikan informasi tambahan tentang service
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Simpan Service
                </button>
                <a href="{{ route('service_catalog.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
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
        // Character counter
        const categoryInput = document.getElementById('category_name');
        const serviceInput = document.getElementById('service_name');
        const descriptionInput = document.getElementById('description');
        const categoryCount = document.getElementById('categoryCount');
        const serviceCount = document.getElementById('serviceCount');
        const descriptionCount = document.getElementById('descriptionCount');

        function updateCharacterCount(inputElement, countElement, maxLength) {
            const length = inputElement.value.length;
            countElement.textContent = `${length}/${maxLength} karakter`;
            
            // Update styling based on character count
            if (length === 0) {
                countElement.className = 'character-count';
            } else if (length > maxLength * 0.8) {
                countElement.className = 'character-count warning';
            } else if (length > maxLength * 0.9) {
                countElement.className = 'character-count error';
            } else {
                countElement.className = 'character-count';
            }
        }

        // Initialize counters
        updateCharacterCount(categoryInput, categoryCount, 100);
        updateCharacterCount(serviceInput, serviceCount, 150);
        updateCharacterCount(descriptionInput, descriptionCount, 500);

        // Add event listeners
        categoryInput.addEventListener('input', () => updateCharacterCount(categoryInput, categoryCount, 100));
        serviceInput.addEventListener('input', () => updateCharacterCount(serviceInput, serviceCount, 150));
        descriptionInput.addEventListener('input', () => updateCharacterCount(descriptionInput, descriptionCount, 500));

        // Form validation
        const form = document.getElementById('serviceForm');

        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Clear previous error states
            document.querySelectorAll('.form-input.error').forEach(input => {
                input.classList.remove('error');
            });

            // Validate required fields
            if (!categoryInput.value.trim()) {
                categoryInput.classList.add('error');
                isValid = false;
            } else if (categoryInput.value.length > 100) {
                categoryInput.classList.add('error');
                isValid = false;
            }
            
            if (!serviceInput.value.trim()) {
                serviceInput.classList.add('error');
                isValid = false;
            } else if (serviceInput.value.length > 150) {
                serviceInput.classList.add('error');
                isValid = false;
            }

            if (descriptionInput.value.length > 500) {
                descriptionInput.classList.add('error');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.form-input.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });

        // Auto focus first field
        if (categoryInput && !categoryInput.value) {
            categoryInput.focus();
        } else if (serviceInput && !serviceInput.value) {
            serviceInput.focus();
        }

        // Real-time validation on blur
        categoryInput.addEventListener('blur', function() {
            if (this.value.trim() && this.value.length <= 100) {
                this.classList.remove('error');
                this.classList.add('success');
                setTimeout(() => this.classList.remove('success'), 2000);
            }
        });

        serviceInput.addEventListener('blur', function() {
            if (this.value.trim() && this.value.length <= 150) {
                this.classList.remove('error');
                this.classList.add('success');
                setTimeout(() => this.classList.remove('success'), 2000);
            }
        });

        // Enter key navigation
        categoryInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                serviceInput.focus();
            }
        });

        serviceInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                descriptionInput.focus();
            }
        });

        // Scroll to top functionality
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

        // Auto-hide success alerts
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'all 0.5s ease';
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 500);
            }, 3000);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to submit form
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                form.dispatchEvent(new Event('submit'));
            }
        });
    });
</script>
@endpush