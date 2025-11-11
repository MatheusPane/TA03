<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>@yield('title', 'Dashboard') - Silalahi Dolok</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/AdminLTELogo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- AdminLTE + Custom -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- TEMA PROFESIONAL & ELEGAN -->
    <style>
        :root {
            /* Warna Profesional */
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --success: #059669;
            --danger: #dc2626;
            --warning: #d97706;
            
            /* Background & Surface */
            --bg-body: #f1f5f9;
            --bg-sidebar: #ffffff;
            --bg-header: #ffffff;
            --bg-content: #f8fafc;
            
            /* Text */
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            
            /* Border */
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            
            /* Shadow */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            
            --sidebar-width: 270px;
            --header-height: 60px;
        }

        [data-bs-theme="dark"] {
            --bg-body: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-header: #1e293b;
            --bg-content: #0f172a;
            
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            
            --border-color: #334155;
            --border-light: #1e293b;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.4);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.5);
        }

        body {
            font-family: 'Source Sans 3', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-primary);
        }

        /* ========== SIDEBAR ========== */
        .app-sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            box-shadow: none;
        }

        .sidebar-brand {
            height: var(--header-height);
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .brand-link {
            display: flex;
            align-items: center;
            color: var(--text-primary) !important;
            text-decoration: none;
            font-weight: 600;
            gap: 0.75rem;
        }

        .brand-image {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: var(--shadow-sm);
        }

        .brand-text {
            font-size: 1.125rem;
            color: var(--text-primary);
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        /* Sidebar Navigation */
        .nav-sidebar {
            padding: 0.75rem 0;
        }

        .nav-header {
            color: var(--text-muted);
            font-size: 0.6875rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            padding: 1.25rem 1.5rem 0.5rem;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            padding: 0.65rem 1.5rem;
            margin: 0.125rem 0.75rem;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .nav-link:hover {
            background-color: var(--bg-content);
            color: var(--text-primary) !important;
        }

        .nav-link.active {
            background-color: var(--primary);
            color: white !important;
            font-weight: 600;
            box-shadow: var(--shadow);
        }

        .nav-link.active .nav-icon {
            color: white;
        }

        .nav-icon {
            width: 20px;
            margin-right: 0.875rem;
            font-size: 1.125rem;
            color: var(--text-secondary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .nav-link:hover .nav-icon {
            color: var(--primary);
        }

        .nav-link.active:hover .nav-icon {
            color: white;
        }

        .nav-arrow {
            margin-left: auto;
            font-size: 0.75rem;
            transition: transform 0.2s ease;
            color: var(--text-muted);
        }

        .nav-item.menu-open > .nav-link > .nav-arrow {
            transform: rotate(90deg);
        }

        .nav-treeview {
            padding: 0.25rem 0;
        }

        .nav-treeview .nav-link {
            padding-left: 3.75rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* ========== HEADER ========== */
        .app-header {
            height: var(--header-height);
            background-color: var(--bg-header);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .app-header .navbar-nav .nav-link {
            color: var(--text-secondary) !important;
            padding: 0.5rem;
            border-radius: 10px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            transition: all 0.15s ease;
        }

        .app-header .navbar-nav .nav-link:hover {
            background-color: var(--bg-content);
            color: var(--text-primary) !important;
        }

        .user-image {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--border-color);
        }

        .user-menu .dropdown-toggle {
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            width: auto;
            height: auto;
            gap: 0.5rem;
        }

        .user-menu .dropdown-toggle:hover {
            background-color: var(--bg-content);
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            border-radius: 12px;
            overflow: hidden;
            margin-top: 0.5rem;
            min-width: 260px;
            background-color: var(--bg-sidebar);
        }

        .user-header {
            padding: 1.75rem 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            text-align: center;
        }

        .user-header img {
            width: 70px;
            height: 70px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow);
        }

        .user-header p {
            margin: 0.875rem 0 0.25rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
        }

        .user-header small {
            opacity: 0.9;
            font-size: 0.8125rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .user-body {
            background-color: var(--bg-sidebar);
            padding: 1rem !important;
        }

        /* Theme Toggle */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.125rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.15s ease;
        }

        .theme-toggle:hover {
            background-color: var(--bg-content);
            color: var(--text-primary);
        }

        /* ========== MAIN CONTENT ========== */
        .app-main {
            background-color: var(--bg-body);
        }

        .app-content-header {
            background-color: var(--bg-header);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 0;
            margin-bottom: 0;
        }

        .app-content-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .app-content-header h3 i {
            color: var(--primary);
            font-size: 1.375rem;
        }

        .app-content-body {
            padding: 1.5rem 0;
        }

        /* ========== BUTTONS ========== */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.15s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .btn-outline-primary {
            border: 1.5px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-outline-danger {
            border: 1.5px solid var(--danger);
            color: var(--danger);
            background: transparent;
        }

        .btn-outline-danger:hover {
            background-color: var(--danger);
            color: white;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .app-sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 1050;
                height: 100vh;
            }
            
            body.sidebar-open .app-sidebar {
                transform: translateX(0);
            }

            body.sidebar-open::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-content);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* ========== SMOOTH TRANSITIONS ========== */
        * {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-duration: 0.15s;
            transition-timing-function: ease-in-out;
        }

        a, button, .nav-link {
            transition: all 0.15s ease;
        }
    </style>

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg">

<div class="app-wrapper">

    <!-- HEADER -->
    <nav class="app-header navbar navbar-expand">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list fs-4"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Theme Toggle -->
                <li class="nav-item">
                    <button class="theme-toggle" id="themeToggle" title="Ganti Tema">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                </li>

                <!-- Search -->
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button" title="Cari">
                        <i class="bi bi-search"></i>
                    </a>
                </li>

                <!-- Fullscreen -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-lte-toggle="fullscreen" title="Layar Penuh">
                        <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                        <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                    </a>
                </li>

                <!-- User Menu -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->avatar ?? asset('assets/img/user2-160x160.jpg') }}"
                             class="user-image me-2" alt="User">
                        <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="user-header text-white">
                            <img src="{{ Auth::user()->avatar ?? asset('assets/img/user2-160x160.jpg') }}"
                                 class="rounded-circle" alt="User">
                            <p>{{ Auth::user()->name }}</p>
                            {{-- <small>{{ Auth::user()->getRoleNames()->first() ?? 'Pengguna' }}</small> --}}
                        </li>
                        <li class="user-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary w-100">
                                        <i class="bi bi-person me-1"></i> Profil
                                    </a>
                                </div>
                                <div class="col-6">
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                            <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- SIDEBAR -->
    @include('layouts.sidebar')

    <!-- MAIN CONTENT -->
    <main class="app-main">
        <div class="app-content">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3>
                                <i class="bi bi-speedometer2"></i>
                                @yield('title')
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>

<!-- Theme Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const icon = toggle.querySelector('i');

        // Load saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateIcon(savedTheme);

        // Toggle theme on click
        toggle.addEventListener('click', function () {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            if (theme === 'dark') {
                icon.className = 'bi bi-sun-fill';
            } else {
                icon.className = 'bi bi-moon-fill';
            }
        }
    });
</script>

@stack('scripts')
</body>
</html>