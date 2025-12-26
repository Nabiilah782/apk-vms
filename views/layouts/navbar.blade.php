<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CloudHost Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            /* Palette warna dari file Anda */
            --color-dark-blue: #080F5C;
            --color-blue: #334EAC;
            --color-light-blue: #7086D1;
            --color-accent-blue: #D0E5FF;
            --color-bg-light: #E7F5FF;
            --color-bg-lighter: #F9FCFF;
            
            /* Warna netral */
            --color-white: #ffffff;
            --color-light-gray: #f5f7fa;
            --color-gray: #e1e5eb;
            --color-dark-gray: #6c757d;
            --color-black: #343a40;
            
            /* Border radius */
            --border-radius-sm: 6px;
            --border-radius-md: 10px;
            --border-radius-lg: 16px;
            
            /* Shadows */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--color-bg-lighter);
            color: var(--color-black);
            line-height: 1.6;
            min-height: 100vh;
            /* Tambah padding-top untuk memberi jarak dari navbar */
            padding-top: 70px;
        }
        
        /* ===== HEADER STYLES ===== */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: linear-gradient(135deg, var(--color-dark-blue) 0%, var(--color-blue) 100%);
            box-shadow: var(--shadow-md);
        }
        
        /* ===== NAVBAR STYLES ===== */
        .navbar {
            color: var(--color-white);
            padding: 0 1.5rem;
            width: 100%;
        }
        
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            color: var(--color-white);
            white-space: nowrap;
        }
        
        .navbar-brand i {
            margin-right: 10px;
            font-size: 1.8rem;
        }
        
        .navbar-menu {
            display: flex;
            list-style: none;
            align-items: center;
            gap: 5px;
        }
        
        .navbar-link {
            position: relative;
            color: var(--color-white);
            text-decoration: none;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s ease;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .navbar-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .navbar-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        /* Dropdown Styles */
        .dropdown {
            position: relative;
        }
        
        .dropdown-toggle {
            display: flex;
            align-items: center;
        }
        
        .dropdown-toggle i {
            margin-left: 5px;
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background-color: var(--color-white);
            box-shadow: var(--shadow-lg);
            border-radius: var(--border-radius-md);
            padding: 0.5rem 0;
            margin-top: 5px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            list-style: none;
        }
        
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown:hover .dropdown-toggle i {
            transform: rotate(180deg);
        }
        
        /* Dropdown Item Styles */
        .dropdown-item {
            position: relative;
            display: block;
            padding: 0.75rem 1.25rem;
            text-decoration: none;
            color: var(--color-black);
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        
        .dropdown-item:hover {
            background-color: var(--color-accent-blue);
        }
        
        .dropdown-item.active {
            background-color: var(--color-bg-light);
            color: var(--color-blue);
            font-weight: 500;
        }
        
        .dropdown-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: var(--color-blue);
            border-radius: 0 2px 2px 0;
        }
        
        .dropdown-item i {
            margin-right: 8px;
            width: 20px;
            color: var(--color-light-blue);
        }
        
        .navbar-user {
            display: flex;
            align-items: center;
            margin-left: 20px;
            white-space: nowrap;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--color-accent-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
            color: var(--color-blue);
            border: 2px solid rgba(255, 255, 255, 0.5);
            flex-shrink: 0;
        }
        
        .user-name {
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: 1rem;
            padding: 5px;
            flex-shrink: 0;
        }
        
        /* ===== CONTENT STYLES ===== */
        .content-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 1.5rem;
        }
        
        /* Header Content */
        .content-header {
            margin-bottom: 30px;
        }
        
        .content-header h1 {
            color: var(--color-dark-blue);
            font-size: 2.5rem;
            margin-bottom: 5px;
        }
        
        .content-header h2 {
            color: var(--color-blue);
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .nav-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .nav-tag {
            background: var(--color-accent-blue);
            color: var(--color-blue);
            padding: 8px 16px;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .nav-tag:hover {
            background: var(--color-light-blue);
            color: white;
        }
        
        .nav-tag.active {
            background: var(--color-blue);
            color: white;
        }
        
        hr {
            border: none;
            height: 2px;
            background: linear-gradient(to right, var(--color-blue), transparent);
            margin: 20px 0;
        }
        
        /* Dashboard Info */
        .dashboard-info {
            background: white;
            padding: 25px;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            margin-bottom: 30px;
            border-left: 5px solid var(--color-blue);
        }
        
        .dashboard-info h3 {
            color: var(--color-dark-blue);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            border-top: 4px solid var(--color-blue);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        
        .stat-card h4 {
            color: var(--color-dark-gray);
            font-size: 1rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-value {
            color: var(--color-dark-blue);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-subtitle {
            color: var(--color-light-blue);
            font-size: 0.9rem;
        }
        
        /* User Actions */
        .user-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--color-gray);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info .user-avatar {
            width: 50px;
            height: 50px;
            margin-right: 0;
        }
        
        .user-details h3 {
            color: var(--color-dark-blue);
            margin-bottom: 5px;
        }
        
        .user-details p {
            color: var(--color-dark-gray);
            font-size: 0.9rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: var(--color-blue);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--color-dark-blue);
        }
        
        .btn-secondary {
            background: var(--color-accent-blue);
            color: var(--color-blue);
        }
        
        .btn-secondary:hover {
            background: var(--color-light-blue);
            color: white;
        }
        
        /* ===== RESPONSIVE DESIGN ===== */
        /* Tablet (768px - 1024px) */
        @media (max-width: 1024px) {
            .navbar-menu {
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, var(--color-dark-blue) 0%, var(--color-blue) 100%);
                flex-direction: column;
                padding: 1rem 0;
                box-shadow: var(--shadow-lg);
                display: none;
                z-index: 999;
                max-height: calc(100vh - 70px);
                overflow-y: auto;
                gap: 0;
            }
            
            .navbar-menu.active {
                display: flex;
            }
            
            .navbar-menu li {
                width: 100%;
            }
            
            .navbar-link, .dropdown-toggle {
                border-radius: 0;
                padding: 15px 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                text-align: left;
                font-size: 1rem;
            }
            
            /* Dropdown menu untuk mobile */
            .dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                background-color: rgba(255, 255, 255, 0.1);
                margin-top: 0;
                padding: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
                border-radius: 0;
                width: 100%;
                min-width: 100%;
                display: block;
            }
            
            .dropdown.active .dropdown-menu {
                max-height: 500px;
            }
            
            .dropdown-item {
                color: var(--color-white);
                padding: 12px 3rem;
                font-size: 0.95rem;
            }
            
            .dropdown-item:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }
            
            .dropdown-item.active {
                background-color: rgba(255, 255, 255, 0.2);
            }
            
            .dropdown-item.active::before {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .navbar-user .user-name {
                display: none;
            }
            
            /* Responsive Content */
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
            
            .user-section {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }
            
            .action-buttons {
                width: 100%;
                justify-content: flex-start;
            }
        }
        
        /* Mobile kecil (≤ 768px) */
        @media (max-width: 768px) {
            .navbar {
                padding: 0 1rem;
            }
            
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .navbar-brand i {
                font-size: 1.5rem;
                margin-right: 8px;
            }
            
            .mobile-menu-toggle {
                font-size: 1.3rem;
                margin-left: 0.5rem;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
                margin-right: 5px;
            }
            
            /* Responsive Content */
            .content-wrapper {
                padding: 20px 1rem;
            }
            
            .content-header h1 {
                font-size: 2rem;
            }
            
            .content-header h2 {
                font-size: 1.3rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
                width: 100%;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        /* Mobile sangat kecil (≤ 576px) */
        @media (max-width: 576px) {
            .navbar-brand span {
                display: none;
            }
            
            .navbar-brand i {
                margin-right: 0;
                font-size: 1.8rem;
            }
            
            .navbar-link, .dropdown-toggle {
                padding: 15px 1.5rem;
            }
            
            .dropdown-item {
                padding: 12px 2.5rem;
            }
            
            /* Responsive Content */
            .content-header h1 {
                font-size: 1.8rem;
            }
            
            .nav-tags {
                flex-direction: column;
            }
            
            .nav-tag {
                text-align: center;
            }
        }
        
        /* Desktop besar (≥ 1025px) */
        @media (min-width: 1025px) {
            .navbar-menu {
                display: flex !important;
            }
        }
    </style>
</head>
<body>
    <!-- ===== HEADER MENYELIMUTI NAVBAR ===== -->
    <header>
        <!-- ===== NAVBAR ===== -->
        <nav class="navbar">
            <div class="navbar-container">
                <a href="index.html" class="navbar-brand">
                    <i class="bi bi-cloud"></i>
                    <span>CloudHost</span>
                </a>
                
                <ul class="navbar-menu" id="navbarMenu">
                    <!-- Dashboard -->
                    <li class="dropdown">
                        <a href="{{ route('dashboard.index') }}" class="navbar-link" data-page="dashboard">
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Service Catalog Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="navbar-link dropdown-toggle" data-page="service-catalog">
                            <span>Service Catalog</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('service_catalog.index') }}" class="dropdown-item" data-page="add-service-catalog">
                                    <i class="bi bi-grid"></i>
                                    Add Service Catalog
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('list_service_catalog.index') }}" class="dropdown-item" data-page="list-service-catalog">
                                    <i class="bi bi-globe"></i>
                                    List Service Catalog
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Billing Dropdown -->
                    <li class="dropdown">
                        <a href="#billing" class="navbar-link dropdown-toggle" data-page="billing">
                            <span>Data</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('data_vendors.index') }}" class="dropdown-item" data-page="invoices">
                                    <i class="bi bi-receipt"></i>
                                    Data Vendors
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item" data-page="billing-history">
                                    <i class="bi bi-clock-history"></i>
                                    Contoh
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Support Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="navbar-link dropdown-toggle" data-page="support">
                            <span>Contoh</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item" data-page="support-tickets">
                                    <i class="bi bi-ticket-detailed"></i>
                                    Contoh
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item" data-page="video-guides">
                                    <i class="bi bi-play-circle"></i>
                                    Contoh
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Settings -->
                    <li class="dropdown">
                        <a href="#" class="navbar-link" data-page="settings">
                            <span>Settings Profile</span>
                        </a>
                    </li>
                </ul>
                
                <div class="navbar-user">
                    <div class="user-avatar">M</div>
                    <div class="user-name">Martin</div>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </nav>
    </header>

    <!-- ===== JAVASCRIPT ===== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const navbarMenu = document.getElementById('navbarMenu');
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            const navLinks = document.querySelectorAll('.navbar-link:not(.dropdown-toggle), .dropdown-item');
            
            // Fungsi untuk menyimpan halaman aktif ke localStorage
            function saveActivePage(pageId) {
                localStorage.setItem('activePage', pageId);
            }
            
            // Fungsi untuk memuat halaman aktif dari localStorage
            function loadActivePage() {
                const savedPage = localStorage.getItem('activePage');
                
                if (savedPage) {
                    // Hapus semua kelas aktif
                    document.querySelectorAll('.navbar-link, .dropdown-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    
                    // Aktifkan halaman yang disimpan
                    const activeLink = document.querySelector(`[data-page="${savedPage}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                    }
                    
                    return savedPage;
                }
                
                return null;
            }
            
            // Inisialisasi: muat halaman aktif
            let activePage = loadActivePage();
            if (!activePage) {
                activePage = 'dashboard'; // Default
            }
            
            // Mobile menu toggle
            mobileMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                navbarMenu.classList.toggle('active');
                this.innerHTML = navbarMenu.classList.contains('active') ? 
                    '<i class="bi bi-x"></i>' : '<i class="bi bi-list"></i>';
            });
            
            // Dropdown toggle untuk mobile SAJA
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    // HANYA untuk mobile (≤ 1024px)
                    if (window.innerWidth <= 1024) {
                        const dropdown = this.parentElement;
                        const isActive = dropdown.classList.contains('active');
                        
                        // Cek apakah href hanya hash (anchor link)
                        const href = this.getAttribute('href');
                        if (href && href.startsWith('#')) {
                            e.preventDefault(); // Hanya untuk anchor links
                        }
                        
                        // Tutup semua dropdown lainnya
                        document.querySelectorAll('.dropdown').forEach(d => {
                            if (d !== dropdown) {
                                d.classList.remove('active');
                            }
                        });
                        
                        // Toggle dropdown saat ini
                        dropdown.classList.toggle('active');
                    }
                });
            });
            
            // Close menu when clicking outside (mobile only)
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024) {
                    const isMenuOpen = navbarMenu.classList.contains('active');
                    const isToggleButton = mobileMenuToggle.contains(e.target);
                    const isInsideMenu = navbarMenu.contains(e.target);
                    
                    if (isMenuOpen && !isInsideMenu && !isToggleButton) {
                        navbarMenu.classList.remove('active');
                        mobileMenuToggle.innerHTML = '<i class="bi bi-list"></i>';
                        
                        // Close all dropdowns
                        document.querySelectorAll('.dropdown').forEach(d => {
                            d.classList.remove('active');
                        });
                    }
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    // Close mobile menu on desktop
                    navbarMenu.classList.remove('active');
                    mobileMenuToggle.innerHTML = '<i class="bi bi-list"></i>';
                    
                    // Close all dropdowns
                    document.querySelectorAll('.dropdown').forEach(d => {
                        d.classList.remove('active');
                    });
                }
            });
            
            // Navbar link clicks
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const pageId = this.getAttribute('data-page');
                    const href = this.getAttribute('href');
                    
                    // Simpan halaman aktif ke localStorage
                    saveActivePage(pageId);
                    
                    // Hapus semua kelas aktif
                    document.querySelectorAll('.navbar-link, .dropdown-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    
                    // Tambah kelas aktif ke link yang diklik
                    this.classList.add('active');
                    
                    // Jika link dropdown-toggle, juga aktifkan parent link
                    if (this.classList.contains('dropdown-item')) {
                        const parentDropdown = this.closest('.dropdown');
                        if (parentDropdown) {
                            const parentLink = parentDropdown.querySelector('.dropdown-toggle');
                            if (parentLink) {
                                parentLink.classList.add('active');
                            }
                        }
                    }
                    
                    // Untuk link anchor atau SPA, cegah default
                    if (href && (href.startsWith('#') || href.includes('route=') || href.includes('{{'))) {
                        e.preventDefault();
                        
                        // Simpan ke localStorage
                        saveActivePage(pageId);
                        
                        // Tutup mobile menu jika terbuka
                        if (window.innerWidth <= 1024) {
                            navbarMenu.classList.remove('active');
                            mobileMenuToggle.innerHTML = '<i class="bi bi-list"></i>';
                            document.querySelectorAll('.dropdown').forEach(d => {
                                d.classList.remove('active');
                            });
                        }
                    } else if (href && href.endsWith('.html')) {
                        // Untuk link HTML, biarkan browser melakukan navigasi
                        // Hanya simpan ke localStorage untuk highlight
                        saveActivePage(pageId);
                        
                        // Tutup mobile menu jika terbuka
                        if (window.innerWidth <= 1024) {
                            setTimeout(() => {
                                navbarMenu.classList.remove('active');
                                mobileMenuToggle.innerHTML = '<i class="bi bi-list"></i>';
                                document.querySelectorAll('.dropdown').forEach(d => {
                                    d.classList.remove('active');
                                });
                            }, 100);
                        }
                    }
                });
            });
            
            // Handle hash changes untuk anchor links
            window.addEventListener('hashchange', function() {
                const hash = window.location.hash.substring(1);
                if (hash) {
                    const pageMap = {
                        'service-catalog': 'service-catalog',
                        'billing': 'billing',
                        'support': 'support'
                    };
                    
                    if (pageMap[hash]) {
                        saveActivePage(pageMap[hash]);
                        loadActivePage();
                    }
                }
            });
            
            // Handle nav-tag clicks
            document.querySelectorAll('.nav-tag').forEach(tag => {
                tag.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tags
                    document.querySelectorAll('.nav-tag').forEach(t => {
                        t.classList.remove('active');
                    });
                    
                    // Add active class to clicked tag
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>