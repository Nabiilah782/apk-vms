@extends('layouts.app')

@section('title', 'Edit List Service Catalog')

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

    .list-form-page {
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
        max-width: 800px;
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
        animation: fadeIn 0.5s ease-out;
        animation-fill-mode: backwards;
    }

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

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }

    .form-label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--primary);
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
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

    /* === INFO BOX === */
    .info-box {
        background: linear-gradient(135deg, var(--bg-light) 0%, var(--accent-light) 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        border: 2px solid rgba(112, 134, 209, 0.2);
        animation: fadeIn 0.5s ease-out 0.3s both;
    }

    .info-box h4 {
        font-size: 15px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-box li {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(112, 134, 209, 0.1);
        font-size: 13px;
        color: var(--primary);
    }

    .info-box li:last-child {
        border-bottom: none;
    }

    .info-box li span:first-child {
        font-weight: 500;
        opacity: 0.8;
    }

    .info-box li span:last-child {
        font-weight: 600;
        background: var(--primary);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
    }

    /* === SERVICES SECTION === */
    .services-section {
        background: var(--bg-white);
        border-radius: 12px;
        padding: 25px;
        border: 2px solid var(--bg-light);
        margin-top: 20px;
        animation: fadeIn 0.5s ease-out 0.4s both;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 12px;
        max-height: 350px;
        overflow-y: auto;
        padding: 10px 5px;
    }

    .service-checkbox {
        display: none;
    }

    .service-item-label {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        background: white;
        border: 2px solid var(--bg-light);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .service-item-label:hover {
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(112, 134, 209, 0.15);
    }

    .service-checkbox:checked + .service-item-label {
        border-color: var(--primary);
        background: linear-gradient(135deg, var(--bg-light) 0%, var(--accent-light) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(51, 78, 172, 0.2);
    }

    .service-item-label::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .service-checkbox:checked + .service-item-label::after {
        transform: translateX(100%);
    }

    .checkbox-icon {
        width: 20px;
        height: 20px;
        border: 2px solid var(--primary-light);
        border-radius: 5px;
        margin-right: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s ease;
        background: white;
    }

    .service-checkbox:checked + .service-item-label .checkbox-icon {
        background-color: var(--primary);
        border-color: var(--primary);
        transform: scale(1.1);
    }

    .checkbox-icon:after {
        content: "✓";
        color: white;
        font-size: 12px;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .service-checkbox:checked + .service-item-label .checkbox-icon:after {
        opacity: 1;
    }

    .service-info {
        flex: 1;
        min-width: 0;
    }

    .service-category {
        font-size: 11px;
        color: var(--primary);
        background: rgba(112, 134, 209, 0.1);
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-block;
        margin-bottom: 6px;
        transition: all 0.3s ease;
    }

    .service-checkbox:checked + .service-item-label .service-category {
        background: rgba(51, 78, 172, 0.2);
        color: var(--primary-dark);
    }

    .service-name {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 14px;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .service-checkbox:checked + .service-item-label .service-name {
        color: var(--primary-dark);
        font-weight: 700;
    }

    .selected-count {
        margin-top: 20px;
        font-size: 14px;
        color: var(--primary);
        font-weight: 600;
        padding: 12px 16px;
        background: var(--bg-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 2px solid var(--accent-light);
    }

    .selected-count .badge {
        background: var(--primary);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .selected-count:hover .badge {
        transform: scale(1.05);
    }

    /* === FORM ACTIONS === */
    .form-actions {
        display: flex;
        gap: 16px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1px solid var(--bg-light);
        animation: fadeIn 0.5s ease-out 0.5s both;
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
        .list-form-page {
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
        
        .services-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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
        
        .services-grid {
            grid-template-columns: 1fr;
            max-height: 300px;
        }
    }

    @media (max-width: 576px) {
        .list-form-page {
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
        
        .services-section {
            padding: 20px;
        }
        
        .section-title {
            font-size: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="list-form-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>
                <i class="bi bi-pencil-square"></i>
                Edit List Service Catalog
            </h1>
            <p>Perbarui list dan pilih services yang akan dimasukkan</p>
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
            <i class="bi bi-list-check"></i>
            Edit List Service
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <h4><i class="bi bi-info-circle"></i> Informasi List</h4>
            <ul>
                <li>
                    <span>ID List</span>
                    <span>#{{ $listServiceCatalog->id }}</span>
                </li>
                <li>
                    <span>Dibuat</span>
                    <span>{{ $listServiceCatalog->created_at->format('d M Y, H:i') }}</span>
                </li>
                <li>
                    <span>Terakhir Update</span>
                    <span>{{ $listServiceCatalog->updated_at->format('d M Y, H:i') }}</span>
                </li>
            </ul>
        </div>

        <form action="{{ route('list_service_catalog.update', $listServiceCatalog->id) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')
            
            <!-- List Name -->
            <div class="form-group">
                <label for="list_name" class="form-label">
                    <i class="bi bi-card-heading"></i>
                    NAMA LIST
                </label>
                <div class="input-wrapper">
                    <i class="bi bi-card-text input-icon"></i>
                    <input 
                        type="text" 
                        id="list_name" 
                        name="list_name" 
                        class="form-input @error('list_name') error @enderror" 
                        value="{{ old('list_name', $listServiceCatalog->list_name) }}"
                        placeholder="Contoh: List Service Cloud, Bundle Infrastructure, dll"
                        required
                        maxlength="150"
                        autofocus
                    >
                </div>
                <div class="character-count" id="listNameCount">
                    {{ strlen(old('list_name', $listServiceCatalog->list_name)) }}/150 karakter
                </div>
                @error('list_name')
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small class="form-help">
                    Masukkan nama list yang akan digunakan untuk mengelompokkan services.
                </small>
            </div>

            <!-- Services Selection -->
            <div class="services-section">
                <h3 class="section-title">
                    <i class="bi bi-check2-square"></i>
                    PILIH SERVICES
                </h3>
                
                <div class="services-grid" id="servicesContainer">
                    @if($services->count() > 0)
                        @foreach($services as $service)
                        <div>
                            <input 
                                type="checkbox" 
                                id="service_{{ $service->id }}" 
                                name="services[]" 
                                value="{{ $service->id }}" 
                                class="service-checkbox"
                                {{ in_array($service->id, old('services', $selectedServices)) ? 'checked' : '' }}
                            >
                            <label for="service_{{ $service->id }}" class="service-item-label">
                                <span class="checkbox-icon"></span>
                                <span class="service-info">
                                    <span class="service-category">{{ $service->category_name }}</span>
                                    <span class="service-name">{{ $service->service_name }}</span>
                                </span>
                            </label>
                        </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 30px; color: var(--primary); opacity: 0.6;">
                            <i class="bi bi-inbox" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                            <p style="font-size: 14px; font-weight: 500;">Tidak ada services tersedia.</p>
                        </div>
                    @endif
                </div>
                
                <div class="selected-count" id="selectedCount">
                    <span>Services Terpilih</span>
                    <span class="badge">{{ count($selectedServices) }}</span>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-check-circle"></i> Update List
                </button>
                <a href="{{ route('list_service_catalog.index') }}" class="btn btn-secondary">
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
        const listNameInput = document.getElementById('list_name');
        const listNameCount = document.getElementById('listNameCount');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('editForm');

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

        // Initialize counter
        updateCharacterCount(listNameInput, listNameCount, 150);

        // Add event listener
        listNameInput.addEventListener('input', () => updateCharacterCount(listNameInput, listNameCount, 150));

        // === UPDATE SELECTED COUNT ===
        const checkboxes = document.querySelectorAll('.service-checkbox');
        const selectedCount = document.getElementById('selectedCount').querySelector('.badge');
        
        function updateSelectedCount() {
            const selected = document.querySelectorAll('.service-checkbox:checked').length;
            selectedCount.textContent = selected;
        }
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        // === FORM VALIDATION ===
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const errors = [];
            
            // Clear previous error states
            document.querySelectorAll('.form-input.error').forEach(input => {
                input.classList.remove('error');
            });

            // Validate list name
            if (!listNameInput.value.trim()) {
                listNameInput.classList.add('error');
                errors.push('Nama list wajib diisi');
                isValid = false;
            } else if (listNameInput.value.trim().length > 150) {
                listNameInput.classList.add('error');
                errors.push('Nama list maksimal 150 karakter');
                isValid = false;
            }
            
            // Validate at least one service selected
            const selectedServices = document.querySelectorAll('.service-checkbox:checked').length;
            if (selectedServices === 0) {
                errors.push('Pilih minimal 1 service');
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
                    window.location.href = "{{ route('list_service_catalog.index') }}";
                }
            }
            
            // Ctrl/Cmd + Enter to submit
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                form.requestSubmit();
            }
        });

        // === SELECT/DESELECT ALL (Optional) ===
        const selectAllBtn = document.createElement('button');
        selectAllBtn.innerHTML = '<i class="bi bi-check-all"></i> Pilih Semua';
        selectAllBtn.type = 'button';
        selectAllBtn.style.cssText = `
            background: var(--bg-light);
            color: var(--primary);
            border: 1px solid var(--accent-light);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        `;
        
        selectAllBtn.addEventListener('mouseenter', function() {
            this.style.background = 'var(--accent-light)';
            this.style.transform = 'translateY(-1px)';
        });
        
        selectAllBtn.addEventListener('mouseleave', function() {
            this.style.background = 'var(--bg-light)';
            this.style.transform = 'translateY(0)';
        });
        
        let allSelected = false;
        selectAllBtn.addEventListener('click', function() {
            allSelected = !allSelected;
            checkboxes.forEach(checkbox => {
                checkbox.checked = allSelected;
            });
            updateSelectedCount();
            this.innerHTML = allSelected 
                ? '<i class="bi bi-x-circle"></i> Batalkan Semua' 
                : '<i class="bi bi-check-all"></i> Pilih Semua';
        });
        
        // Insert button before services grid
        const servicesSection = document.querySelector('.services-section h3');
        servicesSection.insertAdjacentElement('afterend', selectAllBtn);

        // === SEARCH FILTER (Optional) ===
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.placeholder = 'Cari service...';
        searchInput.style.cssText = `
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 2px solid var(--bg-light);
            border-radius: 8px;
            font-size: 13px;
            color: var(--primary-dark);
            background: white;
            margin-bottom: 15px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%237086D1' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 12px center;
            background-size: 16px;
        `;
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const serviceItems = document.querySelectorAll('.service-item-label');
            
            serviceItems.forEach(item => {
                const serviceName = item.querySelector('.service-name').textContent.toLowerCase();
                const serviceCategory = item.querySelector('.service-category').textContent.toLowerCase();
                const parentDiv = item.closest('div');
                
                if (serviceName.includes(searchTerm) || serviceCategory.includes(searchTerm)) {
                    parentDiv.style.display = 'block';
                    item.style.animation = 'fadeIn 0.3s ease-out';
                } else {
                    parentDiv.style.display = 'none';
                }
            });
        });
        
        // Insert search input after select all button
        selectAllBtn.insertAdjacentElement('afterend', searchInput);

        // === INPUT ANIMATIONS ===
        listNameInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
            this.parentElement.style.boxShadow = '0 4px 12px rgba(112, 134, 209, 0.15)';
        });
        
        listNameInput.addEventListener('blur', function() {
            this.parentElement.style.transform = '';
            this.parentElement.style.boxShadow = '';
        });
    });
</script>
@endpush