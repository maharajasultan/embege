<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — MBG Bekasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 260px;
            --primary: #16a34a;
            --primary-dark: #15803d;
            --primary-light: #dcfce7;
            --bg-dark: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-content: #f1f5f9;
            --text-muted: #94a3b8;
            --text-light: #cbd5e1;
            --border: #334155;
            --card-bg: #ffffff;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -2px rgba(0,0,0,.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-content);
            color: #1e293b;
            display: flex;
            min-height: 100vh;
        }

        /* ---- SIDEBAR ---- */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-brand .brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary), #22c55e);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(22,163,74,.4);
        }

        .sidebar-brand .brand-text strong {
            display: block;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
        }

        .sidebar-brand .brand-text span {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 400;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            padding: 8px 12px 6px;
            margin-top: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 2px;
            transition: all .2s;
        }

        .nav-item:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(22,163,74,.3), rgba(34,197,94,.15));
            color: #4ade80;
            border: 1px solid rgba(74,222,128,.15);
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,.05);
            margin-bottom: 8px;
        }

        .admin-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), #22c55e);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
        }

        .admin-info strong {
            display: block;
            color: #fff;
            font-size: 13px;
        }

        .admin-info span {
            color: var(--text-muted);
            font-size: 11px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.2);
            color: #fca5a5;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,.2);
            color: #ef4444;
        }

        /* ---- MAIN CONTENT ---- */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow);
        }

        .topbar-title h1 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .topbar-title p {
            font-size: 13px;
            color: #64748b;
            margin-top: 1px;
        }

        .page-content {
            padding: 28px;
            flex: 1;
        }

        /* ---- CARDS ---- */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h2 {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
        }

        .card-body { padding: 24px; }

        /* ---- ALERTS ---- */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert-warning { background: #fffbeb; border: 1px solid #fed7aa; color: #d97706; }

        /* ---- BUTTONS ---- */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #22c55e);
            color: white;
            box-shadow: 0 2px 8px rgba(22,163,74,.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22,163,74,.4);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #d1d5db;
            color: #374151;
        }

        .btn-outline:hover { background: #f9fafb; }

        .btn-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .btn-danger:hover { background: #fee2e2; }

        .btn-warning {
            background: #fffbeb;
            border: 1px solid #fed7aa;
            color: #d97706;
        }

        .btn-warning:hover { background: #fef3c7; }

        .btn-sm { padding: 6px 12px; font-size: 12px; }

        /* ---- TABLES ---- */
        .table-wrapper { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            background: #f8fafc;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        tbody td {
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #374151;
            vertical-align: middle;
        }

        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }

        /* ---- BADGES ---- */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success { background: #dcfce7; color: #16a34a; }
        .badge-danger  { background: #fee2e2; color: #dc2626; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-info    { background: #dbeafe; color: #2563eb; }
        .badge-gray    { background: #f1f5f9; color: #64748b; }

        /* ---- FORMS ---- */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        .form-label .required { color: #ef4444; margin-left: 3px; }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(22,163,74,.1);
        }

        .form-control.is-invalid { border-color: #ef4444; }

        .invalid-feedback {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-hint { color: #94a3b8; font-size: 12px; margin-top: 5px; }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        /* ---- PAGINATION ---- */
        .pagination { display: flex; gap: 4px; justify-content: center; padding: 20px 0 0; }
        .pagination a, .pagination span {
            padding: 7px 12px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
        .pagination .active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ---- MOBILE TOGGLE ---- */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: #374151;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .menu-toggle { display: block; }
            .page-content { padding: 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <div class="brand-icon">🍱</div>
            <div class="brand-text">
                <strong>MBG Admin</strong>
                <span>Dapur Bekasi</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <div class="nav-section-label">Manajemen Utama</div>
        <a href="{{ route('admin.menus.index') }}"
           class="nav-item {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-days"></i> Jadwal Menu
        </a>
        <a href="{{ route('admin.staffs.index') }}"
           class="nav-item {{ request()->routeIs('admin.staffs.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Staf & Karyawan
        </a>
        <a href="{{ route('admin.schools.index') }}"
           class="nav-item {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
            <i class="fas fa-school"></i> Sekolah Mitra
        </a>

        <div class="nav-section-label">Keuangan & SDM</div>
        <a href="{{ route('admin.budgets.index') }}"
           class="nav-item {{ request()->routeIs('admin.budgets.*') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i> Anggaran
        </a>
        <a href="{{ route('admin.attendances.index') }}"
           class="nav-item {{ request()->routeIs('admin.attendances.*') ? 'active' : '' }}">
            <i class="fas fa-user-check"></i> Absensi Harian
        </a>
        <a href="{{ route('admin.salaries.index') }}"
           class="nav-item {{ request()->routeIs('admin.salaries.*') ? 'active' : '' }}">
            <i class="fas fa-money-check-dollar"></i> Gaji Bulanan
        </a>

        <div class="nav-section-label">Laporan Bulanan</div>
        <a href="{{ route('admin.reports.menus') }}"
           class="nav-item {{ request()->routeIs('admin.reports.menus') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Laporan Menu
        </a>
        <a href="{{ route('admin.reports.budgets') }}"
           class="nav-item {{ request()->routeIs('admin.reports.budgets') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Laporan Anggaran
        </a>
        <a href="{{ route('admin.reports.salaries') }}"
           class="nav-item {{ request()->routeIs('admin.reports.salaries') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i> Rekap Gaji
        </a>

        <div class="nav-section-label">Publik</div>
        <a href="{{ route('home') }}" target="_blank" class="nav-item">
            <i class="fas fa-globe"></i> Lihat Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-profile">
            <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="admin-info">
                <strong>{{ auth()->user()->name }}</strong>
                <span>{{ ucfirst(auth()->user()->role) }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-right-from-bracket"></i> Keluar
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<div class="main-content">
    <header class="topbar">
        <button class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-title">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <p>@yield('page-subtitle', 'Panel Admin MBG Bekasi')</p>
        </div>
        <div style="display:flex; align-items:center; gap:10px;">
            <span style="font-size:13px; color:#64748b;">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
    </header>

    <main class="page-content">
        {{-- Global alerts --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
