@extends('layouts.app')

@section('title', 'Buat List Service Catalog Baru')

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

    .list-service-form-page {
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

    /* === SERVICES SECTION === */
    .services-section {
        margin-top: 20px;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 12px;
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
    }

    .service-item {
        display: none;
    }

    .service-item-label {
        display: flex;
        align-items: center;
        padding: 16px;
        background: white;
        border: 2px solid var(--bg-light);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .service-item-label:hover {
        border-color: var(--primary-light);
        background: var(--bg-white);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8, 15, 92, 0.06);
    }

    .service-item:checked + .service-item-label {
        border-color: var(--primary);
        background: linear-gradient(135deg, var(--bg-white) 0%, rgba(51, 78, 172, 0.05) 100%);
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.1);
    }

    .checkbox-icon {
        width: 20px;
        height: 20px;
        border: 2px solid var(--bg-light);
        border-radius: 6px;
        margin-right: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .service-item:checked + .service-item-label .checkbox-icon {
        background: var(--primary);
        border-color: var(--primary);
    }

    .checkbox-icon:after {
        content: "✓";
        color: white;
        font-size: 12px;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .service-item:checked + .service-item-label .checkbox-icon:after {
        opacity: 1;
    }

    .service-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .service-name {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 14px;
    }

    .service-category {
        font-size: 11px;
        color: var(--primary);
        background: var(--bg-light);
        padding: 4px 8px;
        border-radius: 6px;
        align-self: flex-start;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .service-item:checked + .service-item-label .service-category {
        background: var(--primary-light);
        color: white;
    }

    /* === SELECTED COUNT === */
    .selected-count {
        margin-top: 16px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: var(--primary);
        padding: 8px 16px;
        background: var(--bg-white);
        border-radius: 10px;
        border: 1px solid var(--bg-light);
        transition: all 0.3s ease;
    }

    .selected-count.warning {
        color: var(--warning);
        background: rgba(243, 156, 18, 0.05);
        border-color: rgba(243, 156, 18, 0.2);
    }

    .selected-count.error {
        color: var(--error);
        background: rgba(231, 76, 60, 0.05);
        border-color: rgba(231, 76, 60, 0.2);
    }

    /* === ACTIONS TOOLBAR === */
    .actions-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .search-box {
        position: relative;
        width: 280px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 2px solid var(--bg-light);
        border-radius: 10px;
        font-size: 14px;
        color: var(--primary-dark);
        background: white;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary-light);
        background: var(--bg-white);
        box-shadow: 0 0 0 3px rgba(112, 134, 209, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-light);
        font-size: 16px;
        pointer-events: none;
    }

    .toolbar-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-toolbar {
        padding: 8px 16px;
        border: 2px solid var(--bg-light);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-toolbar:hover {
        background: var(--bg-white);
        border-color: var(--primary-light);
        transform: translateY(-1px);
    }

    .btn-toolbar.primary {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .btn-toolbar.primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    /* === EMPTY STATE === */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        grid-column: 1 / -1;
    }

    .empty-icon {
        font-size: 48px;
        color: var(--bg-light);
        margin-bottom: 16px;
        opacity: 0.6;
    }

    .empty-state h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: var(--primary);
        opacity: 0.6;
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.5;
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

    /* === CHARACTER COUNT === */
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

    /* === HELP TEXT === */
    .form-help {
        display: block;
        margin-top: 8px;
        font-size: 12px;
        color: var(--primary);
        opacity: 0.6;
        line-height: 1.4;
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

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 768px) {
        .list-service-form-page {
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

        .actions-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }

        .toolbar-buttons {
            justify-content: center;
        }

        .services-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .list-service-form-page {
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

        .service-item-label {
            padding: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="list-service-form-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>Buat List Service Catalog Baru</h1>
            <p>Tambahkan list baru dan pilih services yang akan dimasukkan</p>
        </div>
        <a href="{{ route('list_service_catalog.index') }}" class="btn-primary-action">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-title">Form Buat List Service</div>
        
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

        <form action="{{ route('list_service_catalog.store') }}" method="POST" id="createForm">
            @csrf
            
            <!-- List Information Section -->
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Informasi List
                </div>
                
                <!-- List Name Field -->
                <div class="form-group">
                    <label for="list_name" class="form-label required">
                        <i class="bi bi-card-list"></i>
                        Nama List
                    </label>
                    <div class="input-group">
                        <i class="bi bi-textarea-t input-icon"></i>
                        <input 
                            type="text" 
                            id="list_name" 
                            name="list_name" 
                            class="form-input @error('list_name') error @enderror" 
                            value="{{ old('list_name') }}"
                            placeholder=" "
                            required
                            maxlength="255"
                            autofocus
                        >
                        <span class="floating-label">Contoh: List untuk Customer VIP, Bundle Package</span>
                    </div>
                    <div class="character-count" id="listNameCount">0/255 karakter</div>
                    @error('list_name')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <div class="form-help">
                        Nama list harus unik dan deskriptif untuk memudahkan identifikasi
                    </div>
                </div>
            </div>

            <!-- Services Selection Section -->
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-grid-3x3-gap"></i>
                    Pilih Services
                </div>

                <!-- Actions Toolbar -->
                <div class="actions-toolbar">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchServices" placeholder="Cari service...">
                    </div>
                    <div class="toolbar-buttons">
                        <button type="button" class="btn-toolbar" id="selectAllBtn">
                            <i class="bi bi-check2-square"></i> Pilih Semua
                        </button>
                        <button type="button" class="btn-toolbar" id="clearAllBtn">
                            <i class="bi bi-x-square"></i> Batal Pilih Semua
                        </button>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="services-grid" id="servicesContainer">
                    @if($services && $services->count() > 0)
                        @foreach($services as $service)
                        <div class="service-item-wrapper" data-category="{{ strtolower($service->category_name) }}" 
                             data-name="{{ strtolower($service->service_name) }}">
                            <input 
                                type="checkbox" 
                                id="service_{{ $service->id }}" 
                                name="services[]" 
                                value="{{ $service->id }}" 
                                class="service-item"
                                {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                            >
                            <label for="service_{{ $service->id }}" class="service-item-label">
                                <span class="checkbox-icon"></span>
                                <div class="service-info">
                                    <span class="service-name">{{ $service->service_name }}</span>
                                    <span class="service-category">{{ $service->category_name }}</span>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h3>Tidak ada services tersedia</h3>
                            <p>Silakan tambahkan service terlebih dahulu di halaman Service Catalog</p>
                            <a href="{{ route('service_catalog.create') }}" class="btn-toolbar primary" style="margin-top: 16px;">
                                <i class="bi bi-plus"></i> Tambah Service
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Selected Count -->
                <div class="selected-count" id="selectedCount">
                    <i class="bi bi-check-circle"></i> <span id="selectedCountText">Belum ada service terpilih</span>
                </div>

                @error('services')
                    <div class="error-message" style="margin-top: 12px;">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror

                <div class="form-help" style="margin-top: 12px;">
                    Pilih minimal 1 service untuk dimasukkan ke dalam list. Klik pada card service untuk memilih/membatalkan pilihan.
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Simpan List
                </button>
                <a href="{{ route('list_service_catalog.index') }}" class="btn btn-secondary">
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
        // Elements
        const listNameInput = document.getElementById('list_name');
        const listNameCount = document.getElementById('listNameCount');
        const servicesContainer = document.getElementById('servicesContainer');
        const serviceItems = document.querySelectorAll('.service-item');
        const selectedCountElement = document.getElementById('selectedCount');
        const selectedCountText = document.getElementById('selectedCountText');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const clearAllBtn = document.getElementById('clearAllBtn');
        const searchInput = document.getElementById('searchServices');
        const form = document.getElementById('createForm');

        // Character counter for list name
        function updateListNameCount() {
            const length = listNameInput.value.length;
            listNameCount.textContent = `${length}/255 karakter`;
            
            if (length === 0) {
                listNameCount.className = 'character-count';
            } else if (length > 255 * 0.8) {
                listNameCount.className = 'character-count warning';
            } else if (length > 255 * 0.9) {
                listNameCount.className = 'character-count error';
            } else {
                listNameCount.className = 'character-count';
            }
        }

        // Update selected count
        function updateSelectedCount() {
            const selected = document.querySelectorAll('.service-item:checked').length;
            const total = serviceItems.length;
            
            if (selected === 0) {
                selectedCountText.textContent = 'Belum ada service terpilih';
                selectedCountElement.className = 'selected-count error';
            } else if (selected === total) {
                selectedCountText.textContent = `Semua service terpilih (${selected}/${total})`;
                selectedCountElement.className = 'selected-count';
            } else {
                selectedCountText.textContent = `${selected} service terpilih dari ${total}`;
                selectedCountElement.className = 'selected-count';
            }

            // Update toolbar buttons state
            if (selected === total) {
                selectAllBtn.innerHTML = '<i class="bi bi-x-square"></i> Batal Pilih Semua';
            } else {
                selectAllBtn.innerHTML = '<i class="bi bi-check2-square"></i> Pilih Semua';
            }
        }

        // Search functionality
        function filterServices() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const serviceWrappers = document.querySelectorAll('.service-item-wrapper');
            
            let visibleCount = 0;
            serviceWrappers.forEach(wrapper => {
                const serviceName = wrapper.getAttribute('data-name');
                const category = wrapper.getAttribute('data-category');
                
                if (searchTerm === '' || 
                    serviceName.includes(searchTerm) || 
                    category.includes(searchTerm)) {
                    wrapper.style.display = 'block';
                    visibleCount++;
                } else {
                    wrapper.style.display = 'none';
                }
            });

            // Show empty state if no results
            if (visibleCount === 0) {
                servicesContainer.innerHTML = `
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <div class="empty-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3>Tidak ada service ditemukan</h3>
                        <p>Tidak ada service yang cocok dengan pencarian "${searchTerm}"</p>
                    </div>
                `;
            }
        }

        // Select all / clear all
        function toggleSelectAll() {
            const allChecked = Array.from(serviceItems).every(item => item.checked);
            const serviceWrappers = document.querySelectorAll('.service-item-wrapper');
            const isVisibleOnly = searchInput.value.trim() !== '';
            
            let itemsToToggle = serviceItems;
            if (isVisibleOnly) {
                itemsToToggle = Array.from(serviceItems).filter(item => {
                    const wrapper = item.closest('.service-item-wrapper');
                    return wrapper && wrapper.style.display !== 'none';
                });
            }
            
            itemsToToggle.forEach(item => {
                item.checked = !allChecked;
                item.dispatchEvent(new Event('change'));
            });
        }

        function clearAllSelection() {
            serviceItems.forEach(item => {
                item.checked = false;
                item.dispatchEvent(new Event('change'));
            });
        }

        // Form validation
        function validateForm() {
            const listName = listNameInput.value.trim();
            const selectedServices = document.querySelectorAll('.service-item:checked').length;
            let isValid = true;

            // Clear previous error states
            listNameInput.classList.remove('error');
            selectedCountElement.classList.remove('error');

            // Validate list name
            if (!listName) {
                listNameInput.classList.add('error');
                isValid = false;
            } else if (listName.length > 255) {
                listNameInput.classList.add('error');
                isValid = false;
            }

            // Validate at least one service selected
            if (selectedServices === 0) {
                selectedCountElement.classList.add('error');
                isValid = false;
            }

            return isValid;
        }

        // Initialize
        updateListNameCount();
        updateSelectedCount();

        // Event Listeners
        listNameInput.addEventListener('input', updateListNameCount);
        
        serviceItems.forEach(item => {
            item.addEventListener('change', updateSelectedCount);
        });

        searchInput.addEventListener('input', filterServices);

        selectAllBtn.addEventListener('click', toggleSelectAll);
        clearAllBtn.addEventListener('click', clearAllSelection);

        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                
                // Scroll to first error
                const firstError = document.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    
                    // Show error message for services
                    const selectedServices = document.querySelectorAll('.service-item:checked').length;
                    if (selectedServices === 0) {
                        alert('Pilih minimal 1 service untuk dimasukkan ke dalam list.');
                    }
                }
            }
        });

        // Auto focus on list name if empty
        if (listNameInput && !listNameInput.value) {
            listNameInput.focus();
        }

        // Real-time validation on blur
        listNameInput.addEventListener('blur', function() {
            if (this.value.trim() && this.value.length <= 255) {
                this.classList.remove('error');
                this.classList.add('success');
                setTimeout(() => this.classList.remove('success'), 2000);
            }
        });

        // Enter key navigation
        listNameInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchInput.focus();
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

        // Auto-hide alerts
        const alertError = document.querySelector('.alert-error');
        if (alertError) {
            setTimeout(() => {
                alertError.style.transition = 'all 0.5s ease';
                alertError.style.opacity = '0';
                alertError.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alertError.style.display = 'none';
                }, 500);
            }, 5000);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to submit form
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                if (validateForm()) {
                    form.submit();
                }
            }
            
            // Escape to clear search
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
        });
    });
</script>
@endpush