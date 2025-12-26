<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard') - Vendor Management</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Custom CSS untuk palette warna -->
  <style>
    :root {
        /* Palette warna dari file yang diberikan */
        --color-primary: #1a73e8;
        --color-secondary: #334eac;
        --color-accent: #7086d1;
        --color-light-blue: #e3f2fd;
        --color-light-purple: #f3e5f5;
        --color-light-pink: #fce4ec;
        
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
  </style>
  
  <!-- Pindahkan @yield('style') di sini agar custom CSS dari child template bisa override -->
  @stack('styles')
  @yield('styles')
</head>

<body>

  @include('layouts.navbar')

  <main class="body-wrapper">
    <div class="container-fluid py-4">
      @yield('content')
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer" style="text-align: center; padding: 1.5rem; color: var(--color-dark-gray); font-size: 0.9rem; border-top: 1px solid var(--color-gray);">
      <p>&copy; 2025 CloudHost Dashboard. All rights reserved.</p>
      <p style="margin-top: 0.5rem;">This dashboard is for demonstration purposes only.</p>
  </footer>

  {{-- Scripts --}}
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  
  @stack('scripts')
  @yield('scripts')

</body>
</html>