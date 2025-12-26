@extends('layouts.app')

@section('title', 'Daftar Vendor')

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
    }

    .vendors-page {
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
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
    .alert-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
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

    .alert-success .close-btn {
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

    .alert-success .close-btn:hover {
        opacity: 1;
        background: rgba(255, 255, 255, 0.1);
    }

    /* === STATS CONTAINER === */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 30px;
    }

    .stats-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--bg-light);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease-out;
        animation-fill-mode: backwards;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(8, 15, 92, 0.1);
        border-color: var(--accent-light);
    }

    .stats-card:nth-child(1) { animation-delay: 0.1s; }
    .stats-card:nth-child(2) { animation-delay: 0.2s; }
    .stats-card:nth-child(3) { animation-delay: 0.3s; }

    .stats-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stats-info h3 {
        font-size: 12px;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.7;
    }

    .stats-number {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-dark);
        line-height: 1;
    }

    /* === TABLE CONTAINER === */
    .data-table-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid var(--bg-light);
        box-shadow: 0 4px 24px rgba(8, 15, 92, 0.06);
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out 0.4s both;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--bg-light);
        flex-wrap: wrap;
        gap: 16px;
    }

    .table-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: var(--primary);
        border-radius: 2px;
    }

    .search-box {
        position: relative;
        width: 280px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid var(--bg-light);
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: var(--bg-white);
        color: var(--primary-dark);
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary-light);
        background: white;
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

    /* === TABLE STYLES === */
    .vendor-table {
        width: 100%;
        border-collapse: collapse;
    }

    .vendor-table thead th {
        padding: 16px 20px;
        text-align: left;
        color: var(--primary);
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--bg-light);
        background: var(--bg-white);
        white-space: nowrap;
    }

    .vendor-table tbody tr {
        border-bottom: 1px solid var(--bg-light);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .vendor-table tbody tr:hover {
        background: var(--bg-light);
    }

    .vendor-table tbody tr:last-child {
        border-bottom: none;
    }

    .vendor-table td {
        padding: 20px;
        color: var(--primary-dark);
        vertical-align: middle;
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

    .vendor-table tbody tr:nth-child(1) td { animation-delay: 0.1s; }
    .vendor-table tbody tr:nth-child(2) td { animation-delay: 0.2s; }

    /* Vendor name styling */
    .vendor-name {
        font-size: 15px;
        font-weight: 600;
        color: var(--primary-dark);
        transition: all 0.3s ease;
    }

    .vendor-table tbody tr:hover .vendor-name {
        color: var(--primary);
    }

    /* Contact person badge */
    .contact-person {
        display: inline-block;
        padding: 8px 16px;
        background: var(--bg-light);
        color: var(--primary);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid rgba(51, 78, 172, 0.1);
    }

    /* Service lists tags */
    .service-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .service-tag {
        display: inline-block;
        padding: 4px 12px;
        background: linear-gradient(135deg, #7086D1 0%, #334EAC 100%);
        color: white;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Documents count - UPDATED WITH CLICKABLE STYLE */
    .documents-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: var(--accent-light);
        color: var(--primary);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
    }

    .documents-count:hover {
        background: var(--primary-light);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(112, 134, 209, 0.2);
        border-color: var(--primary);
    }

    /* === ACTIONS === */
    .actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid var(--bg-light);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 14px;
        background: white;
        text-decoration: none;
        color: var(--primary);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.15);
    }

    .btn-edit {
        background: var(--bg-white);
        border-color: var(--accent-light);
    }

    .btn-edit:hover {
        background: var(--bg-light);
        border-color: var(--primary-light);
    }

    .btn-delete {
        background: var(--bg-white);
        color: #ff6b6b;
        border-color: rgba(255, 107, 107, 0.2);
    }

    .btn-delete:hover {
        background: rgba(255, 107, 107, 0.05);
        border-color: rgba(255, 107, 107, 0.3);
    }

    /* === EMPTY STATE === */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 64px;
        color: var(--bg-light);
        margin-bottom: 20px;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { 
            transform: translateY(0); 
        }
        50% { 
            transform: translateY(-10px); 
        }
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 12px;
    }

    .empty-state p {
        font-size: 14px;
        color: var(--primary);
        opacity: 0.7;
        max-width: 400px;
        margin: 0 auto 24px;
        line-height: 1.5;
    }

    /* === TABLE FOOTER === */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--bg-light);
        color: var(--primary);
        opacity: 0.7;
        font-size: 13px;
    }

    .badge-count {
        background: var(--primary);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .badge-count:hover {
        transform: scale(1.05);
    }

    /* === MODAL STYLES === */
    .documents-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(8, 15, 92, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease-out;
    }

    .documents-modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 600px;
        max-height: 80vh;
        overflow: hidden;
        animation: slideUp 0.4s ease-out;
        box-shadow: 0 20px 40px rgba(8, 15, 92, 0.15);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        padding: 24px 30px;
        background: var(--primary);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
    }

    .close-modal {
        background: transparent;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .close-modal:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .modal-body {
        padding: 30px;
        max-height: 50vh;
        overflow-y: auto;
    }

    .document-item-modal {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        background: var(--bg-white);
        border-radius: 12px;
        margin-bottom: 12px;
        border: 1px solid var(--bg-light);
        transition: all 0.3s ease;
    }

    .document-item-modal:hover {
        background: var(--bg-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8, 15, 92, 0.08);
    }

    .document-info-modal {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .document-icon-modal {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .document-details {
        flex: 1;
    }

    .document-name {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 14px;
        margin-bottom: 4px;
    }

    .document-meta {
        font-size: 12px;
        color: var(--primary);
        opacity: 0.7;
    }

    .document-actions {
        display: flex;
        gap: 8px;
    }

    .btn-download {
        padding: 8px 16px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-download:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(51, 78, 172, 0.25);
    }

    .no-documents {
        text-align: center;
        padding: 40px 20px;
        color: var(--primary);
    }

    .no-documents i {
        font-size: 48px;
        color: var(--bg-light);
        margin-bottom: 16px;
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {
        .vendors-page {
            padding: 16px;
        }
        
        .page-header {
            padding: 20px;
        }
        
        .data-table-container {
            padding: 24px;
        }
        
        .table-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-box {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .vendor-table {
            display: block;
            overflow-x: auto;
        }
        
        .vendor-table thead th,
        .vendor-table td {
            white-space: nowrap;
            min-width: 120px;
        }
        
        .table-footer {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }

        .modal-content {
            width: 95%;
            max-height: 85vh;
        }

        .modal-body {
            padding: 20px;
        }

        .document-item-modal {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .document-actions {
            justify-content: flex-end;
        }
    }

    @media (max-width: 576px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .btn-primary-action {
            width: 100%;
            justify-content: center;
        }
        
        .page-header-content h1 {
            font-size: 24px;
        }
        
        .data-table-container {
            padding: 20px 16px;
        }
        
        .vendor-table td {
            padding: 16px 12px;
        }
        
        .stats-card {
            padding: 20px;
        }
        
        .stats-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }
        
        .stats-number {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="vendors-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>Data Vendor</h1>
            <p>Kelola informasi vendor, dokumen, dan layanan yang tersedia</p>
        </div>
        <a href="{{ route('data_vendors.create') }}" class="btn-primary-action">
            <i class="bi bi-plus-lg"></i> Tambah Vendor Baru
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button class="close-btn" onclick="this.parentElement.style.display='none'">
                <i class="bi bi-x"></i>
            </button>
        </div>
    @endif

    <!-- Stats Container -->
    <div class="stats-container">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-buildings"></i>
            </div>
            <div class="stats-info">
                <h3>Total Vendor</h3>
                <div class="stats-number">{{ $vendors->count() }}</div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-files"></i>
            </div>
            <div class="stats-info">
                <h3>Total Dokumen</h3>
                <div class="stats-number">{{ $vendors->sum(function($vendor) { return $vendor->documents->count(); }) }}</div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-list-check"></i>
            </div>
            <div class="stats-info">
                <h3>Layanan Terdaftar</h3>
                <div class="stats-number">{{ $vendors->sum(function($vendor) { return $vendor->serviceLists->count(); }) }}</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="data-table-container">
        <div class="table-header">
            <div class="table-title">Daftar Vendor</div>
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Cari vendor...">
            </div>
        </div>
        
        @if($vendors && count($vendors) > 0)
        <table class="vendor-table" id="vendorTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Vendor</th>
                    <th>Kontak Person</th>
                    <th>Alamat</th>
                    <th>Layanan</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendors as $vendor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="vendor-name">{{ $vendor->vendor_name }}</div>
                        <div style="font-size: 13px; color: var(--primary); opacity: 0.6; margin-top: 4px;">
                            ID: #{{ str_pad($vendor->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </td>
                    <td>
                        <div class="contact-person">
                            <i class="bi bi-person"></i> {{ $vendor->contact_person }}
                        </div>
                    </td>
                    <td>
                        <div style="max-width: 200px; font-size: 13px; color: var(--primary);">
                            {{ Str::limit($vendor->address, 50) }}
                        </div>
                    </td>
                    <td>
                        @if($vendor->serviceLists->count() > 0)
                            <div class="service-tags">
                                @foreach($vendor->serviceLists as $service)
                                    <span class="service-tag">{{ $service->list_name }}</span>
                                @endforeach
                            </div>
                        @else
                            <span style="color: var(--primary); opacity: 0.5; font-size: 12px;">Belum ada layanan</span>
                        @endif
                    </td>
                    <td>
                        <div class="documents-count" 
                             onclick="showDocuments({{ $vendor->id }}, '{{ $vendor->vendor_name }}')"
                             title="Klik untuk melihat dokumen">
                            <i class="bi bi-file-earmark"></i>
                            {{ $vendor->documents->count() }} file
                        </div>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('data_vendors.edit', $vendor->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('data_vendors.destroy', $vendor->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus vendor ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="table-footer">
            <div class="showing-info">
                Menampilkan <span class="badge-count">{{ count($vendors) }}</span> vendor
            </div>
            <div class="data-info">
                <i class="bi bi-clock"></i> {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
        
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-buildings"></i>
            </div>
            <h3>Belum ada vendor</h3>
            <p>Mulai dengan menambahkan vendor pertama Anda</p>
            <a href="{{ route('data_vendors.create') }}" class="btn-primary-action">
                <i class="bi bi-plus-lg"></i> Tambah Vendor
            </a>
        </div>
        @endif
    </div>

    <!-- Documents Modal -->
    <div class="documents-modal" id="documentsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Dokumen Vendor</h3>
                <button class="close-modal" onclick="closeModal()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('.vendor-table tbody tr');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            tableRows.forEach((row) => {
                const vendorName = row.querySelector('.vendor-name').textContent.toLowerCase();
                const contactPerson = row.querySelector('.contact-person').textContent.toLowerCase();
                const address = row.cells[3].textContent.toLowerCase();
                
                if (searchTerm === '' || 
                    vendorName.includes(searchTerm) || 
                    contactPerson.includes(searchTerm) ||
                    address.includes(searchTerm)) {
                    row.style.display = '';
                    row.style.animation = 'fadeIn 0.3s ease-out';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Auto-hide success message
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateX(-20px)';
                successAlert.style.transition = 'all 0.5s ease';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 3000);
        }

        // Close modal when clicking outside
        document.getElementById('documentsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    });

    // Function to show documents modal - SIMPLIFIED
    function showDocuments(vendorId, vendorName) {
        // Show loading state
        document.getElementById('modalTitle').textContent = `Dokumen Vendor: ${vendorName}`;
        document.getElementById('modalBody').innerHTML = `
            <div style="text-align: center; padding: 40px;">
                <div style="width: 40px; height: 40px; border: 3px solid var(--bg-light); border-top: 3px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
                <p style="color: var(--primary);">Memuat dokumen...</p>
            </div>
        `;

        // Show modal
        document.getElementById('documentsModal').classList.add('active');

        // Load documents via AJAX biasa (tanpa API)
        fetch(`/vendor-documents/vendor/${vendorId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal memuat dokumen');
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('modalBody').innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('modalBody').innerHTML = `
                <div style="text-align: center; padding: 40px 20px; color: var(--primary);">
                    <i class="bi bi-exclamation-triangle" style="font-size: 48px; color: #ff6b6b; margin-bottom: 16px;"></i>
                    <h5>Gagal Memuat Dokumen</h5>
                    <p>${error.message}</p>
                    <button onclick="showDocuments(${vendorId}, '${vendorName}')" 
                            style="padding: 8px 16px; background: var(--primary); color: white; border: none; border-radius: 6px; margin-top: 12px;">
                        <i class="bi bi-arrow-clockwise"></i> Coba Lagi
                    </button>
                </div>
            `;
        });
    }

    // Function to close modal
    function closeModal() {
        document.getElementById('documentsModal').classList.remove('active');
    }

    // Helper function untuk format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Tambahkan style untuk spinner
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush