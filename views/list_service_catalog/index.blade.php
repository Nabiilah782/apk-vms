@extends('layouts.app')

@section('title', 'List Service Catalog')

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

    .list-service-page {
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
        background: linear-gradient(135deg, var(--success) 0%, #38f9d7 100%);
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

    .alert-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #ff8e8e 100%);
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
    .service-table {
        width: 100%;
        border-collapse: collapse;
    }

    .service-table thead th {
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

    .service-table tbody tr {
        border-bottom: 1px solid var(--bg-light);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .service-table tbody tr:hover {
        background: var(--bg-light);
    }

    .service-table tbody tr:last-child {
        border-bottom: none;
    }

    .service-table td {
        padding: 20px;
        color: var(--primary-dark);
        vertical-align: top;
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

    .service-table tbody tr:nth-child(1) td { animation-delay: 0.1s; }
    .service-table tbody tr:nth-child(2) td { animation-delay: 0.2s; }
    .service-table tbody tr:nth-child(3) td { animation-delay: 0.3s; }

    /* List name styling */
    .list-name-cell {
        font-size: 15px;
        font-weight: 600;
        color: var(--primary-dark);
        transition: all 0.3s ease;
    }

    .service-table tbody tr:hover .list-name-cell {
        color: var(--primary);
    }

    .list-id {
        font-size: 11px;
        color: var(--primary);
        opacity: 0.6;
        margin-top: 4px;
        font-weight: 500;
        background: var(--bg-light);
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    /* Services list container */
    .services-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 180px;
        overflow-y: auto;
        padding-right: 8px;
    }

    /* Service item */
    .service-item {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        background: var(--bg-white);
        border-radius: 8px;
        font-size: 13px;
        border-left: 3px solid var(--primary);
        transition: all 0.2s ease;
    }

    .service-table tbody tr:hover .service-item {
        background: white;
        transform: translateX(2px);
    }

    .service-category {
        font-size: 11px;
        color: white;
        background: var(--primary);
        padding: 3px 8px;
        border-radius: 4px;
        margin-right: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .service-name {
        flex: 1;
        color: var(--primary-dark);
        font-weight: 500;
        line-height: 1.4;
    }

    .no-services {
        font-size: 13px;
        color: var(--primary);
        opacity: 0.5;
        padding: 12px;
        text-align: center;
        font-style: italic;
        background: var(--bg-white);
        border-radius: 8px;
        border: 1px dashed var(--bg-light);
    }

    /* Services count */
    .services-count {
        margin-top: 12px;
        font-size: 12px;
        color: var(--primary);
        opacity: 0.7;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .services-count::before {
        content: '📊';
        font-size: 14px;
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
        color: var(--danger);
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

    /* === SCROLLBAR STYLING === */
    .services-list::-webkit-scrollbar {
        width: 5px;
    }

    .services-list::-webkit-scrollbar-track {
        background: var(--bg-white);
        border-radius: 10px;
    }

    .services-list::-webkit-scrollbar-thumb {
        background: var(--primary-light);
        border-radius: 10px;
    }

    .services-list::-webkit-scrollbar-thumb:hover {
        background: var(--primary);
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {
        .list-service-page {
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
        
        .service-table {
            display: block;
            overflow-x: auto;
        }
        
        .service-table thead th,
        .service-table td {
            white-space: nowrap;
            min-width: 120px;
        }
        
        .table-footer {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }
        
        .service-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
        
        .service-category {
            align-self: flex-start;
        }
        
        .actions {
            justify-content: flex-start;
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
        
        .service-table td {
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
        
        .services-list {
            max-height: 120px;
        }
    }
</style>
@endpush

@section('content')
<div class="list-service-page">
    <!-- Header Section -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>List Service Catalog</h1>
            <p>Kelola daftar service catalog dengan mudah dan efisien</p>
        </div>
        <a href="{{ route('list_service_catalog.create') }}" class="btn-primary-action">
            <i class="bi bi-plus-lg"></i> Buat List Baru
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

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert-danger">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-exclamation-triangle"></i>
                <span>{{ session('error') }}</span>
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
                <i class="bi bi-list-check"></i>
            </div>
            <div class="stats-info">
                <h3>Total Lists</h3>
                <div class="stats-number">{{ $lists->count() }}</div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-server"></i>
            </div>
            <div class="stats-info">
                <h3>Total Services</h3>
                @php
                    $totalServices = $lists->sum(function($list) {
                        return $list->services->count();
                    });
                @endphp
                <div class="stats-number">{{ $totalServices }}</div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stats-info">
                <h3>Aktif</h3>
                <div class="stats-number">{{ $lists->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="data-table-container">
        <div class="table-header">
            <div class="table-title">Daftar Service Catalog</div>
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Cari list atau service...">
            </div>
        </div>
        
        @if($lists->count() > 0)
        <table class="service-table" id="serviceTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>List Name</th>
                    <th>Services</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $index => $list)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: var(--primary);">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td>
                        <div class="list-name-cell">{{ $list->list_name }}</div>
                        <div class="list-id">ID: #{{ $list->id }}</div>
                    </td>
                    <td>
                        <div class="services-list">
                            @if($list->services->count() > 0)
                                @foreach($list->services as $service)
                                <div class="service-item">
                                    <span class="service-category">{{ $service->category_name }}</span>
                                    <span class="service-name">{{ $service->service_name }}</span>
                                </div>
                                @endforeach
                            @else
                                <div class="no-services">No services available</div>
                            @endif
                        </div>
                        <div class="services-count">
                            Total: {{ $list->services->count() }} services
                        </div>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('list_service_catalog.edit', $list->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('list_service_catalog.destroy', $list->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus list ini?')">
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
                Menampilkan <span class="badge-count">{{ $lists->count() }}</span> list
            </div>
            <div class="data-info">
                <i class="bi bi-clock"></i> {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
        
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3>Belum ada list service catalog</h3>
            <p>Mulai dengan membuat list pertama untuk mengelompokkan service Anda</p>
            <a href="{{ route('list_service_catalog.create') }}" class="btn-primary-action">
                <i class="bi bi-plus-lg"></i> Buat List Pertama
            </a>
        </div>
        @endif
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
        // === SEARCH FUNCTIONALITY ===
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('.service-table tbody tr');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            tableRows.forEach((row, index) => {
                const listName = row.querySelector('.list-name-cell').textContent.toLowerCase();
                const services = row.querySelectorAll('.service-name');
                let serviceText = '';
                services.forEach(service => {
                    serviceText += service.textContent.toLowerCase() + ' ';
                });
                
                if (searchTerm === '' || listName.includes(searchTerm) || serviceText.includes(searchTerm)) {
                    row.style.display = '';
                    // Add fade in animation
                    row.style.animation = 'fadeIn 0.3s ease-out';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // === AUTO-HIDE SUCCESS MESSAGE ===
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

        // === AUTO-HIDE ERROR MESSAGE ===
        const errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.opacity = '0';
                errorAlert.style.transform = 'translateX(-20px)';
                errorAlert.style.transition = 'all 0.5s ease';
                setTimeout(() => {
                    errorAlert.remove();
                }, 500);
            }, 4000);
        }

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

        // === CATEGORY FILTER ===
        const categoryBadges = document.querySelectorAll('.service-category');
        categoryBadges.forEach(badge => {
            badge.addEventListener('click', function(e) {
                e.stopPropagation();
                const category = this.textContent.trim();
                searchInput.value = category;
                searchInput.dispatchEvent(new Event('input'));
            });
        });

        // === ADD KEYBOARD SHORTCUTS ===
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + F for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
            
            // Escape to clear search
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.blur();
            }
            
            // Ctrl/Cmd + N for new list
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                document.querySelector('.btn-primary-action').click();
            }
        });

        // === TABLE HOVER EFFECTS ===
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'var(--bg-light)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });

        // === SERVICE ITEM HOVER EFFECTS ===
        const serviceItems = document.querySelectorAll('.service-item');
        serviceItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
                this.style.boxShadow = '0 2px 8px rgba(51, 78, 172, 0.1)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
    });
</script>
@endpush