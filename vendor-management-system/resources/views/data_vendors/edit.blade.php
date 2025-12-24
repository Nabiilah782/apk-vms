@extends('layouts.app')

@section('title', 'Edit Vendor')

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

    .vendor-form-page {
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

    /* === VENDOR INFO CARD === */
    .vendor-info-card {
        background: linear-gradient(135deg, var(--bg-light) 0%, var(--accent-light) 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        border: 1px solid var(--primary-light);
    }

    .vendor-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .vendor-id {
        background: var(--primary);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .vendor-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .info-item {
        font-size: 13px;
        color: var(--primary-dark);
    }

    .info-label {
        font-weight: 600;
        margin-bottom: 4px;
        opacity: 0.7;
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
        justify-content: space-between;
        animation: slideInRight 0.4s ease-out;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .alert-error .close-btn {
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        transition: all 0.2s ease;
        opacity: 0.8;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
    }

    .alert-error .close-btn:hover {
        opacity: 1;
        background: rgba(255, 255, 255, 0.1);
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

    /* === EXISTING DOCUMENTS === */
    .existing-documents {
        margin-top: 20px;
    }

    .document-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        background: white;
        border: 1px solid var(--bg-light);
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .document-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .document-icon {
        color: var(--primary);
        font-size: 20px;
    }

    .delete-document {
        color: var(--error);
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
    }

    .delete-document:hover {
        background: rgba(231, 76, 60, 0.1);
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

    .form-input, .form-textarea, .form-file {
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

    .form-textarea {
        min-height: 100px;
        resize: vertical;
        padding-left: 16px;
    }

    .form-input:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--primary-light);
        background: var(--bg-white);
        box-shadow: 0 0 0 3px rgba(112, 134, 209, 0.1);
    }

    .form-input.error, .form-textarea.error {
        border-color: var(--error);
        background: rgba(231, 76, 60, 0.02);
    }

    .error-message {
        color: var(--error);
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }

    /* === MULTI SELECT === */
    .multiselect-container {
        position: relative;
    }

    .multiselect-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid var(--bg-light);
        border-radius: 10px;
        margin-top: 5px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 4px 12px rgba(8, 15, 92, 0.1);
    }

    .multiselect-dropdown.show {
        display: block;
    }

    .multiselect-option {
        padding: 12px 16px;
        cursor: pointer;
        transition: background-color 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .multiselect-option:hover {
        background-color: var(--bg-light);
    }

    .multiselect-option.selected {
        background-color: var(--accent-light);
        color: var(--primary-dark);
        font-weight: 600;
    }

    .multiselect-option .check-icon {
        opacity: 0;
        font-size: 14px;
    }

    .multiselect-option.selected .check-icon {
        opacity: 1;
    }

    .selected-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .selected-tag {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .remove-tag {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 0;
        font-size: 14px;
        display: flex;
        align-items: center;
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

    /* === FILE UPLOAD === */
    .form-file {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid var(--bg-light);
        border-radius: 10px;
        font-size: 14px;
        color: var(--primary-dark);
        background: white;
        cursor: pointer;
    }

    .file-preview {
        margin-top: 10px;
    }

    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        background: white;
        border: 1px solid var(--bg-light);
        border-radius: 8px;
        margin-bottom: 8px;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .vendor-form-page {
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
</style>
@endpush

@section('content')
<div class="vendor-form-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>Edit Vendor</h1>
            <p>Perbarui informasi vendor, dokumen, dan layanan yang tersedia</p>
        </div>
        <a href="{{ route('data_vendors.index') }}" class="btn-primary-action">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-title">Form Edit Vendor</div>
        
        <!-- Vendor Info Card -->
        <div class="vendor-info-card">
            <div class="vendor-info-header">
                <h3 style="color: var(--primary-dark); font-size: 16px; margin: 0;">Informasi Vendor</h3>
                <div class="vendor-id">ID: #{{ str_pad($vendor->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="vendor-info-grid">
                <div class="info-item">
                    <div class="info-label">Dibuat</div>
                    <div>{{ $vendor->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Terakhir Update</div>
                    <div>{{ $vendor->updated_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Total Dokumen</div>
                    <div>{{ $vendor->documents->count() }} file</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Total Layanan</div>
                    <div>{{ $vendor->serviceLists->count() }} layanan</div>
                </div>
            </div>
        </div>
        
        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert-error">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>Terdapat kesalahan dalam pengisian form</strong>
                    </div>
                    <ul style="margin: 0; padding-left: 20px; font-size: 13px; opacity: 0.9;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="close-btn" onclick="this.parentElement.style.display='none'">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button class="close-btn" onclick="this.parentElement.style.display='none'">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        @endif

        <form action="{{ route('data_vendors.update', $vendor->id) }}" method="POST" id="vendorForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Vendor Information Section -->
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Informasi Vendor
                </div>
                
                <!-- Vendor Name -->
                <div class="form-group">
                    <label for="vendor_name" class="form-label required">
                        <i class="bi bi-building"></i>
                        Nama Vendor
                    </label>
                    <div class="input-group">
                        <i class="bi bi-building input-icon"></i>
                        <input 
                            type="text" 
                            id="vendor_name" 
                            name="vendor_name" 
                            class="form-input @error('vendor_name') error @enderror" 
                            value="{{ old('vendor_name', $vendor->vendor_name) }}"
                            placeholder="Masukkan nama vendor"
                            required
                            maxlength="100"
                        >
                    </div>
                    @error('vendor_name')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Contact Person -->
                <div class="form-group">
                    <label for="contact_person" class="form-label required">
                        <i class="bi bi-person"></i>
                        Kontak Person
                    </label>
                    <div class="input-group">
                        <i class="bi bi-person input-icon"></i>
                        <input 
                            type="text" 
                            id="contact_person" 
                            name="contact_person" 
                            class="form-input @error('contact_person') error @enderror" 
                            value="{{ old('contact_person', $vendor->contact_person) }}"
                            placeholder="Masukkan nama kontak person"
                            required
                            maxlength="100"
                        >
                    </div>
                    @error('contact_person')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address" class="form-label required">
                        <i class="bi bi-geo-alt"></i>
                        Alamat
                    </label>
                    <div class="input-group">
                        <i class="bi bi-geo-alt input-icon"></i>
                        <textarea 
                            id="address" 
                            name="address" 
                            class="form-textarea @error('address') error @enderror" 
                            placeholder="Masukkan alamat lengkap vendor"
                            required
                            rows="3"
                        >{{ old('address', $vendor->address) }}</textarea>
                    </div>
                    @error('address')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Service Lists Section -->
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-list-check"></i>
                    Layanan Vendor
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-tags"></i>
                        Pilih Layanan
                    </label>
                    <div class="multiselect-container">
                        <div class="input-group">
                            <i class="bi bi-search input-icon"></i>
                            <input 
                                type="text" 
                                id="serviceSearch" 
                                class="form-input" 
                                placeholder="Ketik untuk mencari atau pilih layanan..."
                                autocomplete="off"
                            >
                        </div>
                        
                        <div class="multiselect-dropdown" id="serviceDropdown">
                            @foreach($serviceLists as $service)
                                <div class="multiselect-option" data-value="{{ $service->id }}">
                                    <i class="bi bi-check-circle check-icon"></i>
                                    {{ $service->list_name }}
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Hidden input for selected services -->
                        <input type="hidden" name="service_lists" id="selectedServices" 
                               value="{{ old('service_lists', json_encode($selectedServiceLists)) }}">
                        
                        <div class="selected-tags" id="selectedTags">
                            <!-- Selected tags will appear here -->
                        </div>
                    </div>
                    <small style="display: block; margin-top: 8px; font-size: 12px; color: var(--primary); opacity: 0.6;">
                        Pilih layanan yang tersedia untuk vendor ini. Klik untuk memilih/deselect.
                    </small>
                    @error('service_lists')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Documents Section -->
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-files"></i>
                    Dokumen Vendor
                </div>
                
                <!-- Existing Documents -->
                <div class="existing-documents">
                    <h4 style="color: var(--primary); margin-bottom: 15px; font-size: 14px;">Dokumen yang sudah ada:</h4>
                    @foreach($vendor->documents as $document)
                    <div class="document-item" style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: 12px;
                        background: white;
                        border: 1px solid var(--bg-light);
                        border-radius: 8px;
                        margin-bottom: 8px;
                    ">
                        <div class="document-info" style="display: flex; align-items: center; gap: 10px;">
                            <div class="document-icon" style="color: var(--primary);">
                                <i class="bi bi-file-earmark"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--primary-dark); font-size: 14px;">
                                    {{ basename($document->file_path) }}
                                </div>
                                <div style="font-size: 12px; color: var(--primary); opacity: 0.6;">
                                    {{ $document->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('vendor.documents.download', $document->id) }}" 
                               class="btn btn-sm btn-primary" 
                               style="padding: 4px 8px; font-size: 12px;"
                               target="_blank">
                                <i class="bi bi-download"></i>
                            </a>
                            <button type="button" 
                                    class="btn btn-sm btn-danger delete-document" 
                                    style="padding: 4px 8px; font-size: 12px;"
                                    data-document-id="{{ $document->id }}"
                                    onclick="deleteDocument(this, {{ $document->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Add New Documents -->
                <div class="form-group" style="margin-top: 20px;">
                    <label class="form-label">
                        <i class="bi bi-upload"></i>
                        Tambah Dokumen Baru (Opsional)
                    </label>
                    
                    <input 
                        type="file" 
                        id="file_path" 
                        name="file_path[]" 
                        class="form-file" 
                        multiple 
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                    >
                    
                    <div class="file-preview" id="fileList"></div>
                    
                    <small style="display: block; margin-top: 8px; font-size: 12px; color: var(--primary); opacity: 0.6;">
                        Tambah dokumen baru terkait vendor. Maksimal 2MB per file.
                    </small>
                    @error('file_path.*')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-check-circle"></i> Update Vendor
                </button>
                <a href="{{ route('data_vendors.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Multi-select functionality for service lists
        const serviceSearch = document.getElementById('serviceSearch');
        const serviceDropdown = document.getElementById('serviceDropdown');
        const selectedServicesInput = document.getElementById('selectedServices');
        const selectedTags = document.getElementById('selectedTags');
        const serviceOptions = serviceDropdown.querySelectorAll('.multiselect-option');
        
        let selectedServices = [];
        
        // Load existing selected services
        try {
            const existingServices = JSON.parse(selectedServicesInput.value);
            if (Array.isArray(existingServices) && existingServices.length > 0) {
                selectedServices = existingServices.map(id => id.toString());
                updateSelectedServices();
                updateDropdownSelection();
            }
        } catch (e) {
            console.error('Error parsing selected services:', e);
        }
        
        // Show dropdown on focus or click
        serviceSearch.addEventListener('focus', function() {
            serviceDropdown.classList.add('show');
            filterServices();
        });
        
        serviceSearch.addEventListener('click', function() {
            serviceDropdown.classList.add('show');
            filterServices();
        });
        
        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.multiselect-container')) {
                serviceDropdown.classList.remove('show');
            }
        });
        
        // Filter services
        serviceSearch.addEventListener('input', filterServices);
        
        function filterServices() {
            const searchTerm = serviceSearch.value.toLowerCase();
            
            serviceOptions.forEach(option => {
                const text = option.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    option.style.display = 'flex';
                } else {
                    option.style.display = 'none';
                }
            });
        }
        
        // Select/Deselect service
        serviceOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                
                const serviceId = this.getAttribute('data-value');
                const index = selectedServices.indexOf(serviceId);
                
                if (index === -1) {
                    // Add service
                    selectedServices.push(serviceId);
                    this.classList.add('selected');
                } else {
                    // Remove service
                    selectedServices.splice(index, 1);
                    this.classList.remove('selected');
                }
                
                updateSelectedServices();
                
                // Don't clear search, just close dropdown
                serviceDropdown.classList.remove('show');
            });
        });
        
        // Update dropdown selection display
        function updateDropdownSelection() {
            serviceOptions.forEach(option => {
                const serviceId = option.getAttribute('data-value');
                if (selectedServices.includes(serviceId)) {
                    option.classList.add('selected');
                } else {
                    option.classList.remove('selected');
                }
            });
        }
        
        // Remove selected service
        function removeService(serviceId) {
            const index = selectedServices.indexOf(serviceId);
            if (index !== -1) {
                selectedServices.splice(index, 1);
                updateSelectedServices();
                updateDropdownSelection();
            }
        }
        
        function updateSelectedServices() {
            // Update hidden input
            selectedServicesInput.value = JSON.stringify(selectedServices);
            
            // Update tags display
            selectedTags.innerHTML = '';
            
            selectedServices.forEach(serviceId => {
                const option = Array.from(serviceOptions).find(opt => opt.getAttribute('data-value') === serviceId);
                if (option) {
                    const serviceName = option.textContent.trim();
                    const tag = document.createElement('div');
                    tag.className = 'selected-tag';
                    tag.innerHTML = `
                        ${serviceName}
                        <button type="button" class="remove-tag" onclick="event.stopPropagation(); removeService('${serviceId}')">
                            <i class="bi bi-x"></i>
                        </button>
                    `;
                    selectedTags.appendChild(tag);
                }
            });
            
            // Update global removeService function
            window.removeService = removeService;
        }
        
        // File upload preview
        const fileInput = document.getElementById('file_path');
        const fileList = document.getElementById('fileList');
        
        fileInput.addEventListener('change', function() {
            fileList.innerHTML = '';
            
            if (this.files.length > 0) {
                Array.from(this.files).forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    const icon = getFileIcon(fileExtension);
                    
                    fileItem.innerHTML = `
                        <div class="file-info">
                            <div class="file-icon">
                                <i class="bi ${icon}"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--primary-dark); font-size: 14px;">
                                    ${file.name}
                                </div>
                                <div style="font-size: 12px; color: var(--primary); opacity: 0.6;">
                                    ${formatFileSize(file.size)}
                                </div>
                            </div>
                        </div>
                        <button type="button" class="remove-file" data-index="${index}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                    fileList.appendChild(fileItem);
                });
                
                // Add remove file functionality
                document.querySelectorAll('.remove-file').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = this.getAttribute('data-index');
                        removeFileFromInput(index);
                        this.parentElement.remove();
                    });
                });
            }
        });
        
        function removeFileFromInput(index) {
            const dt = new DataTransfer();
            const files = fileInput.files;
            
            for (let i = 0; i < files.length; i++) {
                if (i !== parseInt(index)) {
                    dt.items.add(files[i]);
                }
            }
            
            fileInput.files = dt.files;
        }
        
        function getFileIcon(extension) {
            const icons = {
                'pdf': 'bi-file-earmark-pdf',
                'jpg': 'bi-file-earmark-image',
                'jpeg': 'bi-file-earmark-image',
                'png': 'bi-file-earmark-image',
                'doc': 'bi-file-earmark-word',
                'docx': 'bi-file-earmark-word'
            };
            return icons[extension] || 'bi-file-earmark';
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // Form validation
        const form = document.getElementById('vendorForm');
        const submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', function(e) {
            console.log('Form submitted');
            console.log('Selected Services JSON:', selectedServicesInput.value);
            
            let isValid = true;
            
            // Clear previous error states
            document.querySelectorAll('.form-input.error, .form-textarea.error').forEach(input => {
                input.classList.remove('error');
            });
            
            // Validate required fields
            const vendorName = document.getElementById('vendor_name');
            const contactPerson = document.getElementById('contact_person');
            const address = document.getElementById('address');
            
            if (!vendorName.value.trim()) {
                vendorName.classList.add('error');
                isValid = false;
                showError(vendorName, 'Nama vendor wajib diisi');
            }
            
            if (!contactPerson.value.trim()) {
                contactPerson.classList.add('error');
                isValid = false;
                showError(contactPerson, 'Kontak person wajib diisi');
            }
            
            if (!address.value.trim()) {
                address.classList.add('error');
                isValid = false;
                showError(address, 'Alamat wajib diisi');
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.form-input.error, .form-textarea.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                // Add loading state
                submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Menyimpan...';
                submitBtn.disabled = true;
            }
        });
        
        function showError(element, message) {
            // Remove existing error message
            const existingError = element.parentElement.nextElementSibling;
            if (existingError && existingError.classList.contains('error-message')) {
                existingError.remove();
            }
            
            // Add new error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${message}`;
            element.parentElement.parentElement.appendChild(errorDiv);
        }
        
        // Initialize dropdown selection
        updateDropdownSelection();
    });

    // Function to delete document
    function deleteDocument(button, documentId) {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-arrow-clockwise"></i>';
            
            fetch(`/vendor-documents/${documentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.closest('.document-item').remove();
                    alert('Dokumen berhasil dihapus');
                } else {
                    alert('Gagal menghapus dokumen: ' + data.message);
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-trash"></i>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus dokumen');
                button.disabled = false;
                button.innerHTML = '<i class="bi bi-trash"></i>';
            });
        }
    }
</script>
@endpush