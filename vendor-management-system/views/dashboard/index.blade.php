@extends('layouts.app')

@section('title', 'Dashboard Vendor Management')

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

    .dashboard-vendor-page {
        padding: 20px;
        background: var(--bg-white);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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
    .dashboard-header {
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
        animation: fadeIn 0.6s ease-out 0.1s both;
    }

    .header-content h1 {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-content h1::before {
        content: '';
        width: 4px;
        height: 28px;
        background: var(--primary);
        border-radius: 2px;
    }

    .header-content p {
        font-size: 14px;
        color: var(--primary);
        opacity: 0.8;
        max-width: 500px;
        line-height: 1.5;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-dashboard {
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

    .btn-dashboard:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(51, 78, 172, 0.35);
        text-decoration: none;
        color: white;
    }

    .btn-dashboard-secondary {
        background: var(--bg-light);
        color: var(--primary);
        border: 1px solid var(--accent-light);
    }

    .btn-dashboard-secondary:hover {
        background: var(--accent-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(112, 134, 209, 0.2);
    }

    /* === STATS CARDS === */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
        animation: fadeIn 0.6s ease-out 0.2s both;
    }

    .stats-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--bg-light);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(8, 15, 92, 0.1);
        border-color: var(--accent-light);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary);
        transition: transform 0.3s ease;
        transform: scaleY(0);
        transform-origin: top;
    }

    .stats-card:hover::before {
        transform: scaleY(1);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        flex-shrink: 0;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stats-content {
        flex: 1;
        min-width: 0;
    }

    .stats-title {
        font-size: 12px;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.7;
    }

    .stats-number {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-dark);
        line-height: 1;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stats-change {
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .stats-change.positive {
        color: var(--success);
    }

    .stats-change.negative {
        color: var(--error);
    }

    .stats-change.neutral {
        color: var(--primary);
        opacity: 0.6;
    }

    /* === DASHBOARD GRID === */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        animation: fadeIn 0.6s ease-out 0.3s both;
    }

    @media (max-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* === RECENT VENDORS === */
    .section-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--bg-light);
        box-shadow: 0 4px 24px rgba(8, 15, 92, 0.06);
        transition: all 0.3s ease;
    }

    .section-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(8, 15, 92, 0.1);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--bg-light);
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary);
        font-size: 20px;
        background: var(--bg-light);
        padding: 8px;
        border-radius: 10px;
    }

    .section-actions .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: transparent;
        color: var(--primary);
        border: 1px solid var(--bg-light);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .section-actions .btn-action:hover {
        background: var(--bg-light);
        border-color: var(--primary-light);
        text-decoration: none;
        color: var(--primary-dark);
    }

    /* === VENDOR TABLE === */
    .vendor-table {
        width: 100%;
        border-collapse: collapse;
    }

    .vendor-table thead th {
        padding: 16px;
        text-align: left;
        color: var(--primary);
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--bg-light);
        background: var(--bg-white);
        white-space: nowrap;
    }

    .vendor-table tbody tr {
        border-bottom: 1px solid var(--bg-light);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .vendor-table tbody tr:hover {
        background: var(--bg-light);
        transform: translateX(4px);
    }

    .vendor-table tbody tr:last-child {
        border-bottom: none;
    }

    .vendor-table td {
        padding: 16px;
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
    .vendor-table tbody tr:nth-child(3) td { animation-delay: 0.3s; }

    .vendor-name {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .vendor-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: white;
        font-weight: 600;
        flex-shrink: 0;
    }

    .vendor-info {
        flex: 1;
        min-width: 0;
    }

    .vendor-info h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 4px;
        line-height: 1.3;
        word-wrap: break-word;
    }

    .vendor-info p {
        font-size: 12px;
        color: var(--primary);
        opacity: 0.7;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .vendor-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-block;
    }

    .status-active {
        background: rgba(39, 174, 96, 0.1);
        color: var(--success);
        border: 1px solid rgba(39, 174, 96, 0.2);
    }

    .status-inactive {
        background: rgba(231, 76, 60, 0.1);
        color: var(--error);
        border: 1px solid rgba(231, 76, 60, 0.2);
    }

    .status-pending {
        background: rgba(243, 156, 18, 0.1);
        color: var(--warning);
        border: 1px solid rgba(243, 156, 18, 0.2);
    }

    /* === SERVICE TAGS === */
    .service-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        max-width: 200px;
    }

    .service-tag {
        background: var(--bg-light);
        color: var(--primary);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: 1px solid rgba(112, 134, 209, 0.1);
    }

    /* === QUICK ACTIONS === */
    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .action-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid var(--bg-light);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .action-card:hover {
        background: var(--bg-light);
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(112, 134, 209, 0.15);
    }

    .action-card::after {
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

    .action-card:hover::after {
        transform: translateX(100%);
    }

    .action-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .action-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 6px;
    }

    .action-desc {
        font-size: 12px;
        color: var(--primary);
        opacity: 0.7;
        line-height: 1.4;
    }

    /* === PERFORMANCE CHART === */
    .chart-container {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--bg-light);
        box-shadow: 0 4px 24px rgba(8, 15, 92, 0.06);
        margin-top: 24px;
        animation: fadeIn 0.6s ease-out 0.4s both;
    }

    .chart-placeholder {
        height: 200px;
        background: linear-gradient(135deg, var(--bg-white) 0%, var(--bg-light) 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-weight: 500;
        border: 2px dashed var(--accent-light);
    }

    /* === EMPTY STATE === */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-icon {
        font-size: 48px;
        color: var(--bg-light);
        margin-bottom: 16px;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { 
            transform: translateY(0); 
        }
        50% { 
            transform: translateY(-8px); 
        }
    }

    .empty-state h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: var(--primary);
        opacity: 0.7;
        max-width: 300px;
        margin: 0 auto 20px;
        line-height: 1.4;
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {
        .dashboard-vendor-page {
            padding: 16px;
        }
        
        .dashboard-header {
            padding: 20px;
        }
        
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .section-card {
            padding: 20px;
        }
        
        .vendor-table {
            display: block;
            overflow-x: auto;
        }
        
        .vendor-table thead th,
        .vendor-table td {
            white-space: nowrap;
            min-width: 120px;
            padding: 12px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        
        .header-actions {
            width: 100%;
        }
        
        .btn-dashboard {
            width: 100%;
            justify-content: center;
        }
        
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .stats-card {
            padding: 20px;
        }
        
        .stats-number {
            font-size: 28px;
        }
        
        .vendor-name {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-vendor-page {
            padding: 12px;
        }
        
        .dashboard-header {
            padding: 16px;
        }
        
        .header-content h1 {
            font-size: 24px;
        }
        
        .section-card {
            padding: 16px;
        }
        
        .vendor-table td {
            padding: 10px 8px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-vendor-page">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>
                <i class="bi bi-building"></i>
                Dashboard Vendor Management
            </h1>
            <p>Kelola vendor, monitor performa, dan lihat statistik terbaru</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('data_vendors.create') ?? '#' }}" class="btn-dashboard">
                <i class="bi bi-plus-lg"></i> Tambah Vendor Baru
            </a>
            <a href="{{ route('data_vendors.index') ?? '#' }}" class="btn-dashboard btn-dashboard-secondary">
                <i class="bi bi-list-ul"></i> Lihat Semua Vendor
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-building"></i>
            </div>
            <div class="stats-content">
                <div class="stats-title">Total Vendor</div>
                <div class="stats-number" id="totalVendors">0</div>
                <div class="stats-change" id="vendorGrowth">
                    <i class="bi bi-dash"></i>
                    <span>Loading...</span>
                </div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stats-content">
                <div class="stats-title">Vendor Aktif</div>
                <div class="stats-number" id="activeVendors">0</div>
                <div class="stats-change neutral" id="activePercentage">
                    Loading...
                </div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stats-content">
                <div class="stats-title">Pendaftaran Baru</div>
                <div class="stats-number" id="newVendors">0</div>
                <div class="stats-change positive">
                    <i class="bi bi-arrow-up"></i> bulan ini
                </div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-tags"></i>
            </div>
            <div class="stats-content">
                <div class="stats-title">Total Layanan</div>
                <div class="stats-number" id="totalServices">0</div>
                <div class="stats-change neutral" id="avgServices">
                    Loading...
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Recent Vendors -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-clock-history"></i>
                        Vendor Terbaru
                    </h2>
                    <div class="section-actions">
                        <a href="{{ route('data_vendors.index') ?? '#' }}" class="btn-action">
                            <i class="bi bi-arrow-right"></i> Lihat Semua
                        </a>
                    </div>
                </div>
                
                <div id="recentVendorsContainer">
                    <table class="vendor-table">
                        <thead>
                            <tr>
                                <th>VENDOR</th>
                                <th>KONTAK</th>
                                <th>LAYANAN</th>
                                <th>STATUS</th>
                                <th>TANGGAL DIBUAT</th>
                            </tr>
                        </thead>
                        <tbody id="vendorsTableBody">
                            <!-- Data akan dimuat via JavaScript -->
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px;">
                                    <div class="empty-icon">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </div>
                                    <p>Memuat data vendor...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Quick Actions -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-lightning"></i>
                        Aksi Cepat
                    </h2>
                </div>
                
                <div class="quick-actions">
                    <div class="action-card" onclick="window.location='{{ route('data_vendors.create') ?? '#' }}'">
                        <div class="action-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h3 class="action-title">Tambah Vendor Baru</h3>
                        <p class="action-desc">Tambahkan vendor baru ke sistem</p>
                    </div>
                    
                    <div class="action-card" onclick="showExportModal()">
                        <div class="action-icon">
                            <i class="bi bi-download"></i>
                        </div>
                        <h3 class="action-title">Ekspor Data</h3>
                        <p class="action-desc">Ekspor data vendor ke Excel atau PDF</p>
                    </div>
                    
                    <div class="action-card" onclick="generatePerformanceReport()">
                        <div class="action-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3 class="action-title">Buat Laporan</h3>
                        <p class="action-desc">Generate laporan kinerja vendor</p>
                    </div>
                    
                    <div class="action-card" onclick="manageCategories()">
                        <div class="action-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <h3 class="action-title">Kelola Kategori</h3>
                        <p class="action-desc">Kelola kategori dan layanan vendor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="chart-container">
        <div class="section-header">
            <h2 class="section-title">
                <i class="bi bi-bar-chart"></i>
                Statistik Pendaftaran Vendor
            </h2>
            <div class="section-actions">
                <select id="timeRange" class="btn-action" style="padding: 8px 12px; background: var(--bg-light); border: 1px solid var(--accent-light); border-radius: 8px;">
                    <option value="month">Bulan Ini</option>
                    <option value="quarter">3 Bulan</option>
                    <option value="year">Tahun Ini</option>
                </select>
            </div>
        </div>
        <div class="chart-placeholder" id="vendorChart">
            <div style="text-align: center; padding: 20px;">
                <i class="bi bi-bar-chart" style="font-size: 48px; color: var(--primary-light); margin-bottom: 16px;"></i>
                <h4 style="color: var(--primary-dark); margin-bottom: 8px;">Statistik Pendaftaran</h4>
                <p style="color: var(--primary); opacity: 0.7; font-size: 14px;">
                    Menampilkan grafik pendaftaran vendor
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-download"></i> Ekspor Data Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Pilih format ekspor:</p>
                <div class="d-flex gap-2">
                    <button class="btn btn-success" onclick="exportData('excel')">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </button>
                    <button class="btn btn-danger" onclick="exportData('pdf')">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // === DASHBOARD DATA ===
    const DASHBOARD_DATA = {
        // Stats data
        totalVendors: 156,
        activeVendors: 142,
        newVendorsThisMonth: 12,
        totalServices: 478,
        
        // Recent vendors sample data
        recentVendors: [
            {
                id: 1,
                name: "PT Teknologi Maju Indonesia",
                avatar: "TM",
                address: "Jl. Sudirman No. 123, Jakarta",
                contact: "Budi Santoso",
                services: ["Cloud Hosting", "Database", "Networking"],
                status: "active",
                createdDate: "15 Jan 2024"
            },
            {
                id: 2,
                name: "CV Solusi Digital Nusantara",
                avatar: "SD",
                address: "Jl. Thamrin No. 45, Bandung",
                contact: "Sari Dewi",
                services: ["Web Development", "Mobile App"],
                status: "active",
                createdDate: "10 Jan 2024"
            },
            {
                id: 3,
                name: "UD Jaya Abadi Teknologi",
                avatar: "JA",
                address: "Jl. Gajah Mada No. 67, Surabaya",
                contact: "Ahmad Rizki",
                services: ["IT Support", "Hardware"],
                status: "pending",
                createdDate: "05 Jan 2024"
            },
            {
                id: 4,
                name: "PT Network Solutions",
                avatar: "NS",
                address: "Jl. Merdeka No. 89, Medan",
                contact: "Dian Pertiwi",
                services: ["Network Infrastructure", "Security"],
                status: "active",
                createdDate: "02 Jan 2024"
            },
            {
                id: 5,
                name: "CV Digital Kreatif",
                avatar: "DK",
                address: "Jl. Asia Afrika No. 101, Bandung",
                contact: "Rudi Hermawan",
                services: ["UI/UX Design", "Digital Marketing"],
                status: "inactive",
                createdDate: "28 Des 2023"
            }
        ],
        
        // Chart data
        monthlyStats: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            data: [12, 18, 15, 22, 25, 30, 28, 32, 35, 40, 38, 45]
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize dashboard
        initializeDashboard();
        
        // Load stats with animation
        setTimeout(() => {
            loadDashboardStats();
        }, 500);
        
        // Load recent vendors
        setTimeout(() => {
            loadRecentVendors();
        }, 800);
        
        // Initialize chart
        setTimeout(() => {
            initializeChart();
        }, 1200);
        
        // Setup event listeners
        setupEventListeners();
    });

    function initializeDashboard() {
        // Smooth scroll to top on load
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Add loading animation
        showLoadingAnimation();
    }

    function showLoadingAnimation() {
        // Create loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'dashboardLoading';
        loadingOverlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--bg-white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        `;
        
        loadingOverlay.innerHTML = `
            <div style="text-align: center;">
                <div style="width: 60px; height: 60px; border: 4px solid var(--bg-light); border-top: 4px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
                <h4 style="color: var(--primary-dark); margin-bottom: 8px;">Memuat Dashboard</h4>
                <p style="color: var(--primary); opacity: 0.7; font-size: 14px;">Menyiapkan data vendor...</p>
            </div>
        `;
        
        document.body.appendChild(loadingOverlay);
        
        // Remove after 1.5 seconds
        setTimeout(() => {
            loadingOverlay.style.opacity = '0';
            setTimeout(() => {
                if (loadingOverlay.parentNode) {
                    loadingOverlay.parentNode.removeChild(loadingOverlay);
                }
            }, 300);
        }, 1500);
    }

    function loadDashboardStats() {
        // Calculate percentages and growth
        const vendorGrowth = 12; // 12% growth from last month
        const activePercentage = Math.round((DASHBOARD_DATA.activeVendors / DASHBOARD_DATA.totalVendors) * 100);
        const avgServices = (DASHBOARD_DATA.totalServices / DASHBOARD_DATA.totalVendors).toFixed(1);
        
        // Update stats with animation
        animateNumber('totalVendors', 0, DASHBOARD_DATA.totalVendors);
        animateNumber('activeVendors', 0, DASHBOARD_DATA.activeVendors);
        animateNumber('newVendors', 0, DASHBOARD_DATA.newVendorsThisMonth);
        animateNumber('totalServices', 0, DASHBOARD_DATA.totalServices);
        
        // Update percentages
        document.getElementById('vendorGrowth').innerHTML = `
            <i class="bi bi-arrow-up"></i>
            <span>${vendorGrowth}% dari bulan lalu</span>
        `;
        
        document.getElementById('activePercentage').textContent = `${activePercentage}% dari total`;
        document.getElementById('avgServices').textContent = `${avgServices} per vendor`;
        
        // Set color for growth
        const growthElement = document.getElementById('vendorGrowth');
        growthElement.className = `stats-change ${vendorGrowth >= 0 ? 'positive' : 'negative'}`;
    }

    function animateNumber(elementId, start, end, duration = 1000) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value.toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    function loadRecentVendors() {
        const tableBody = document.getElementById('vendorsTableBody');
        if (!tableBody) return;
        
        // Clear loading state
        tableBody.innerHTML = '';
        
        // Add vendor rows
        DASHBOARD_DATA.recentVendors.forEach(vendor => {
            const row = document.createElement('tr');
            row.onclick = () => navigateToVendor(vendor.id);
            
            const serviceTags = vendor.services.slice(0, 2).map(service => 
                `<span class="service-tag">${service}</span>`
            ).join('');
            
            const extraServices = vendor.services.length > 2 
                ? `<span class="service-tag">+${vendor.services.length - 2}</span>` 
                : '';
            
            row.innerHTML = `
                <td>
                    <div class="vendor-name">
                        <div class="vendor-avatar">${vendor.avatar}</div>
                        <div class="vendor-info">
                            <h4>${vendor.name}</h4>
                            <p>
                                <i class="bi bi-geo-alt"></i>
                                ${vendor.address}
                            </p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="vendor-info">
                        <p>
                            <i class="bi bi-person"></i>
                            ${vendor.contact}
                        </p>
                    </div>
                </td>
                <td>
                    <div class="service-tags">
                        ${serviceTags}${extraServices}
                    </div>
                </td>
                <td>
                    <span class="vendor-status status-${vendor.status}">
                        ${vendor.status === 'active' ? 'Aktif' : 
                          vendor.status === 'pending' ? 'Pending' : 'Nonaktif'}
                    </span>
                </td>
                <td>
                    <div class="vendor-info">
                        <p>
                            <i class="bi bi-calendar"></i>
                            ${vendor.createdDate}
                        </p>
                    </div>
                </td>
            `;
            
            tableBody.appendChild(row);
        });
    }

    function navigateToVendor(vendorId) {
        // Simulate navigation to vendor detail/edit page
        console.log(`Navigating to vendor ${vendorId}`);
        alert(`Akan membuka halaman detail vendor ID: ${vendorId}\n\nPada implementasi sebenarnya, ini akan mengarahkan ke halaman edit vendor.`);
    }

    function initializeChart() {
        const chartContainer = document.getElementById('vendorChart');
        if (!chartContainer) return;
        
        // Simple bar chart using CSS (for demo)
        const chartData = DASHBOARD_DATA.monthlyStats;
        const maxValue = Math.max(...chartData.data);
        
        chartContainer.innerHTML = `
            <div style="padding: 20px; width: 100%;">
                <div style="display: flex; justify-content: space-between; align-items: flex-end; height: 160px; gap: 4px;">
                    ${chartData.data.map((value, index) => `
                        <div style="display: flex; flex-direction: column; align-items: center; flex: 1;">
                            <div style="
                                width: 20px;
                                height: ${(value / maxValue) * 120}px;
                                background: linear-gradient(to top, var(--primary) 0%, var(--primary-light) 100%);
                                border-radius: 4px;
                                transition: height 0.5s ease;
                                position: relative;
                            ">
                                <div style="
                                    position: absolute;
                                    top: -25px;
                                    left: 50%;
                                    transform: translateX(-50%);
                                    background: var(--primary-dark);
                                    color: white;
                                    padding: 2px 6px;
                                    border-radius: 4px;
                                    font-size: 11px;
                                    font-weight: 600;
                                    opacity: 0;
                                    transition: opacity 0.3s ease;
                                ">${value}</div>
                            </div>
                            <div style="margin-top: 8px; font-size: 12px; color: var(--primary); font-weight: 500;">
                                ${chartData.labels[index]}
                            </div>
                        </div>
                    `).join('')}
                </div>
                <div style="margin-top: 20px; padding: 12px; background: var(--bg-light); border-radius: 8px;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-size: 12px; color: var(--primary); opacity: 0.7;">Total Vendor Bulan Ini</div>
                            <div style="font-size: 24px; font-weight: 700; color: var(--primary-dark);">${chartData.data[11]}</div>
                        </div>
                        <div style="color: var(--success); font-weight: 600; font-size: 14px;">
                            <i class="bi bi-arrow-up"></i> ${Math.round(((chartData.data[11] - chartData.data[10]) / chartData.data[10]) * 100)}%
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add hover effects to bars
        setTimeout(() => {
            const bars = chartContainer.querySelectorAll('div[style*="background: linear-gradient(to top"]');
            bars.forEach(bar => {
                bar.addEventListener('mouseenter', function() {
                    const tooltip = this.querySelector('div[style*="position: absolute"]');
                    if (tooltip) tooltip.style.opacity = '1';
                });
                
                bar.addEventListener('mouseleave', function() {
                    const tooltip = this.querySelector('div[style*="position: absolute"]');
                    if (tooltip) tooltip.style.opacity = '0';
                });
            });
        }, 100);
    }

    function setupEventListeners() {
        // Time range selector
        const timeRangeSelect = document.getElementById('timeRange');
        if (timeRangeSelect) {
            timeRangeSelect.addEventListener('change', function() {
                console.log('Time range changed to:', this.value);
                // In real implementation, this would reload chart data
                showNotification(`Menampilkan data untuk ${this.value === 'month' ? 'Bulan Ini' : this.value === 'quarter' ? '3 Bulan Terakhir' : 'Tahun Ini'}`);
            });
        }
        
        // Search functionality
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.placeholder = '🔍 Cari vendor...';
        searchInput.style.cssText = `
            width: 100%;
            padding: 10px 16px;
            border: 2px solid var(--bg-light);
            border-radius: 8px;
            font-size: 14px;
            color: var(--primary-dark);
            background: white;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        `;
        
        const recentVendorsSection = document.querySelector('.section-card .section-header');
        if (recentVendorsSection) {
            recentVendorsSection.insertAdjacentElement('afterend', searchInput);
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const vendorRows = document.querySelectorAll('.vendor-table tbody tr');
                
                vendorRows.forEach(row => {
                    const vendorName = row.querySelector('.vendor-info h4').textContent.toLowerCase();
                    const contactPerson = row.querySelector('.vendor-info p').textContent.toLowerCase();
                    
                    if (vendorName.includes(searchTerm) || contactPerson.includes(searchTerm)) {
                        row.style.display = '';
                        row.style.animation = 'fadeIn 0.3s ease-out';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            searchInput.addEventListener('focus', function() {
                this.style.borderColor = 'var(--primary-light)';
                this.style.boxShadow = '0 0 0 3px rgba(112, 134, 209, 0.1)';
            });
            
            searchInput.addEventListener('blur', function() {
                this.style.borderColor = 'var(--bg-light)';
                this.style.boxShadow = 'none';
            });
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + F for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            }
            
            // Escape to clear search
            if (e.key === 'Escape' && searchInput && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.blur();
            }
        });
    }

    // Modal functions
    function showExportModal() {
        const modal = new bootstrap.Modal(document.getElementById('exportModal'));
        modal.show();
    }

    function exportData(format) {
        const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
        modal.hide();
        
        showNotification(`Mengekspor data vendor dalam format ${format.toUpperCase()}...`, 'info');
        
        // Simulate export process
        setTimeout(() => {
            showNotification(`Data vendor berhasil diekspor! File ${format}.zip akan diunduh.`, 'success');
            
            // Create and trigger download
            const fileName = `vendor_data_${new Date().toISOString().split('T')[0]}.${format}`;
            const blob = new Blob(['Simulated export data'], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }, 1500);
    }

    function generatePerformanceReport() {
        showNotification('Membuat laporan kinerja vendor...', 'info');
        
        setTimeout(() => {
            showNotification('Laporan kinerja vendor berhasil dibuat!', 'success');
            
            // Show report preview
            const reportData = {
                date: new Date().toLocaleDateString('id-ID'),
                totalVendors: DASHBOARD_DATA.totalVendors,
                activeVendors: DASHBOARD_DATA.activeVendors,
                newVendors: DASHBOARD_DATA.newVendorsThisMonth,
                topServices: ['Cloud Hosting', 'IT Support', 'Web Development']
            };
            
            const reportContent = `
                <div style="padding: 20px;">
                    <h4 style="color: var(--primary-dark); margin-bottom: 20px;">
                        <i class="bi bi-graph-up"></i> Laporan Kinerja Vendor
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 20px;">
                        <div style="background: var(--bg-light); padding: 16px; border-radius: 8px;">
                            <div style="font-size: 12px; color: var(--primary); opacity: 0.7;">Total Vendor</div>
                            <div style="font-size: 24px; font-weight: 700; color: var(--primary-dark);">${reportData.totalVendors}</div>
                        </div>
                        <div style="background: var(--bg-light); padding: 16px; border-radius: 8px;">
                            <div style="font-size: 12px; color: var(--primary); opacity: 0.7;">Vendor Aktif</div>
                            <div style="font-size: 24px; font-weight: 700; color: var(--primary-dark);">${reportData.activeVendors}</div>
                        </div>
                    </div>
                    <div style="background: var(--bg-light); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                        <div style="font-size: 12px; color: var(--primary); opacity: 0.7; margin-bottom: 8px;">Top 3 Layanan</div>
                        ${reportData.topServices.map(service => `
                            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(112, 134, 209, 0.1);">
                                <span style="color: var(--primary-dark);">${service}</span>
                                <span style="color: var(--primary); font-weight: 600;">${Math.floor(Math.random() * 50) + 20} vendor</span>
                            </div>
                        `).join('')}
                    </div>
                    <div style="font-size: 12px; color: var(--primary); opacity: 0.7; text-align: center;">
                        Dibuat pada ${reportData.date}
                    </div>
                </div>
            `;
            
            Swal.fire({
                title: 'Laporan Kinerja',
                html: reportContent,
                width: 600,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Download PDF',
                cancelButtonText: 'Tutup',
                confirmButtonColor: 'var(--primary)',
            }).then((result) => {
                if (result.isConfirmed) {
                    exportData('pdf');
                }
            });
        }, 2000);
    }

    function manageCategories() {
        showNotification('Membuka manajemen kategori...', 'info');
        
        setTimeout(() => {
            Swal.fire({
                title: 'Kelola Kategori Vendor',
                html: `
                    <div style="text-align: left;">
                        <p style="margin-bottom: 16px; color: var(--primary);">Kelola kategori dan layanan yang tersedia untuk vendor:</p>
                        
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--primary-dark);">Tambah Kategori Baru</label>
                            <input type="text" id="newCategory" placeholder="Nama kategori" style="width: 100%; padding: 10px; border: 2px solid var(--bg-light); border-radius: 8px;">
                        </div>
                        
                        <div style="max-height: 200px; overflow-y: auto; border: 1px solid var(--bg-light); border-radius: 8px; padding: 12px;">
                            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--bg-light);">
                                <span style="font-weight: 600; color: var(--primary-dark);">Kategori</span>
                                <span style="font-weight: 600; color: var(--primary-dark);">Jumlah Vendor</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--bg-light);">
                                <span>IT Services</span>
                                <span>45</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--bg-light);">
                                <span>Cloud Computing</span>
                                <span>38</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--bg-light);">
                                <span>Network Infrastructure</span>
                                <span>27</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                                <span>Software Development</span>
                                <span>52</span>
                            </div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: 'var(--primary)',
                preConfirm: () => {
                    const newCategory = document.getElementById('newCategory').value;
                    if (newCategory.trim()) {
                        return { newCategory: newCategory.trim() };
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    showNotification(`Kategori "${result.value.newCategory}" berhasil ditambahkan!`, 'success');
                }
            });
        }, 1000);
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            background: ${type === 'success' ? 'var(--success)' : type === 'error' ? 'var(--error)' : 'var(--primary)'};
            color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 12px;
        `;
        
        const icon = type === 'success' ? 'bi-check-circle' : 
                     type === 'error' ? 'bi-exclamation-circle' : 'bi-info-circle';
        
        notification.innerHTML = `
            <i class="bi ${icon}" style="font-size: 20px;"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
        
        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }

    // Auto refresh dashboard every 30 seconds
    setInterval(() => {
        // Update stats with slight random variations
        const stats = ['totalVendors', 'activeVendors', 'newVendors', 'totalServices'];
        stats.forEach(statId => {
            const element = document.getElementById(statId);
            if (element) {
                const current = parseInt(element.textContent.replace(/,/g, '')) || 0;
                const change = Math.floor(Math.random() * 3);
                const newValue = current + (Math.random() > 0.5 ? change : -change);
                if (newValue > 0) {
                    animateNumber(statId, current, newValue, 500);
                }
            }
        });
    }, 30000);
</script>
@endpush