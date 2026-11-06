<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Portal transparansi publik Dapur Makan Bergizi Gratis (MBG) - Pantau jadwal menu, informasi gizi, dan distribusi makanan bergizi ke sekolah.')">
    <title>@yield('title', 'Dapur MBG Bekasi') | Portal Transparansi MBG</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🍱</text></svg>">

    <style>
        /* ===========================
           DESIGN SYSTEM / TOKENS
        =========================== */
        :root {
            --clr-primary:       #16a34a;
            --clr-primary-dark:  #14532d;
            --clr-primary-light: #bbf7d0;
            --clr-primary-50:    #f0fdf4;
            --clr-secondary:     #f97316;
            --clr-secondary-light: #fed7aa;
            --clr-accent:        #0ea5e9;
            --clr-white:         #ffffff;
            --clr-gray-50:       #f8fafc;
            --clr-gray-100:      #f1f5f9;
            --clr-gray-200:      #e2e8f0;
            --clr-gray-400:      #94a3b8;
            --clr-gray-500:      #64748b;
            --clr-gray-600:      #475569;
            --clr-gray-700:      #334155;
            --clr-gray-800:      #1e293b;
            --clr-gray-900:      #0f172a;
            --font-heading:      'Outfit', sans-serif;
            --font-body:         'Plus Jakarta Sans', sans-serif;
            --radius-sm:         6px;
            --radius-md:         10px;
            --radius-lg:         16px;
            --radius-xl:         20px;
            --shadow-sm:         0 1px 2px rgba(0,0,0,.04);
            --shadow-md:         0 4px 12px rgba(0,0,0,.05), 0 1px 3px rgba(0,0,0,.03);
            --shadow-lg:         0 12px 24px rgba(0,0,0,.06), 0 4px 8px rgba(0,0,0,.04);
            --shadow-primary:    0 8px 24px rgba(22,163,74,.15);
            --transition:        all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===========================
           RESET & BASE
        =========================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }
        body {
            font-family: var(--font-body);
            background-color: var(--clr-primary-50);
            color: var(--clr-gray-700);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        img { max-width: 100%; height: auto; display: block; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        button { cursor: pointer; border: none; background: none; font-family: inherit; }

        /* ===========================
           NAVBAR
        =========================== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--clr-gray-200);
            padding: 0 24px;
        }
        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--clr-primary-dark);
            transition: var(--transition);
        }
        .navbar-brand:hover { opacity: 0.85; }
        .navbar-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(22,163,74,0.3);
            background: white;
        }
        .navbar-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .navbar-brand span { display: flex; flex-direction: column; }
        .navbar-brand .brand-name { font-size: 1rem; line-height: 1.1; }
        .navbar-brand .brand-sub { font-size: 0.65rem; font-weight: 400; color: var(--clr-gray-500); letter-spacing: 0.05em; }
        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 40px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--clr-gray-600);
            transition: var(--transition);
        }
        .nav-link:hover {
            background: rgba(22,163,74,0.08);
            color: var(--clr-primary);
        }
        .nav-link.active {
            background: rgba(22,163,74,0.1);
            color: var(--clr-primary);
        }
        .nav-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            background: linear-gradient(135deg, var(--clr-primary), #22c55e);
            color: white;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            box-shadow: 0 2px 8px rgba(22,163,74,0.3);
        }

        /* Hamburger */
        .navbar-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            padding: 8px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }
        .navbar-toggle:hover { background: var(--clr-gray-100); }
        .navbar-toggle span {
            width: 24px;
            height: 2px;
            background: var(--clr-gray-700);
            border-radius: 2px;
            transition: var(--transition);
        }

        /* ===========================
           MAIN CONTENT
        =========================== */
        .main-content {
            min-height: calc(100vh - 68px - 200px);
        }

        /* ===========================
           FOOTER
        =========================== */
        .footer {
            background: var(--clr-gray-900);
            color: var(--clr-gray-400);
            padding: 48px 24px 24px;
            margin-top: 80px;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .footer-brand { color: var(--clr-white); }
        .footer-brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .footer-brand-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            background: white;
        }
        .footer-brand-logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .footer-brand-logo span { font-family: var(--font-heading); font-weight: 700; font-size: 1rem; }
        .footer-desc { font-size: 0.875rem; line-height: 1.7; color: var(--clr-gray-400); max-width: 300px; }
        .footer-col-title {
            font-family: var(--font-heading);
            font-weight: 600;
            color: var(--clr-white);
            font-size: 0.9rem;
            margin-bottom: 16px;
        }
        .footer-col ul { display: flex; flex-direction: column; gap: 10px; }
        .footer-col ul li a {
            font-size: 0.875rem;
            color: var(--clr-gray-400);
            transition: var(--transition);
        }
        .footer-col ul li a:hover { color: var(--clr-primary-light); }
        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 24px;
            font-size: 0.8rem;
            color: var(--clr-gray-500);
        }
        .footer-bottom .heart { color: var(--clr-secondary); }

        /* ===========================
           UTILITY CLASSES
        =========================== */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .section-header { text-align: center; margin-bottom: 48px; }
        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            background: var(--clr-primary-light);
            color: var(--clr-primary-dark);
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            font-family: var(--font-heading);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .section-title {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 2rem;
            color: var(--clr-gray-900);
            line-height: 1.2;
            margin-bottom: 12px;
        }
        .section-subtitle {
            font-size: 1rem;
            color: var(--clr-gray-500);
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.7;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: var(--radius-md);
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--clr-primary), #22c55e);
            color: white;
            box-shadow: var(--shadow-primary);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(22,163,74,.2);
        }
        .btn-outline {
            background: white;
            color: var(--clr-primary);
            border: 2px solid var(--clr-primary);
        }
        .btn-outline:hover {
            background: var(--clr-primary-50);
            transform: translateY(-2px);
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            font-family: var(--font-heading);
        }
        .badge-green { background: var(--clr-primary-light); color: var(--clr-primary-dark); }
        .badge-orange { background: var(--clr-secondary-light); color: #9a3412; }
        .badge-blue { background: #e0f2fe; color: #0c4a6e; }

        /* ===========================
           MODAL
        =========================== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.2s ease;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: white;
            border-radius: var(--radius-xl);
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 80px rgba(0,0,0,0.25);
            animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-header {
            padding: 28px 28px 20px;
            background: linear-gradient(135deg, var(--clr-primary), #22c55e);
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
            color: white;
            position: relative;
        }
        .modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 34px;
            height: 34px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            color: white;
            font-size: 1.1rem;
            font-family: var(--font-heading);
        }
        .modal-close:hover { background: rgba(255,255,255,0.35); transform: rotate(90deg); }
        .modal-date {
            font-size: 0.8rem;
            opacity: 0.85;
            font-weight: 500;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .modal-title {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 800;
        }
        .modal-body { padding: 24px 28px 28px; display: flex; flex-direction: column; gap: 20px; }
        .modal-section-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--clr-gray-400);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
            font-family: var(--font-heading);
        }
        .modal-section-label .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--clr-primary);
        }

        /* Gizi cards */
        .gizi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .gizi-card {
            text-align: center;
            padding: 14px 10px;
            border-radius: var(--radius-md);
            border: 1px solid var(--clr-gray-100);
            background: var(--clr-gray-50);
        }
        .gizi-card .value {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }
        .gizi-card .label { font-size: 0.72rem; color: var(--clr-gray-500); font-weight: 500; }
        .gizi-kalori .value { color: var(--clr-secondary); }
        .gizi-karbo .value { color: var(--clr-accent); }
        .gizi-protein .value { color: var(--clr-primary); }

        /* Lauk list */
        .lauk-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .lauk-tag {
            padding: 5px 12px;
            background: var(--clr-primary-50);
            border: 1px solid var(--clr-primary-light);
            color: var(--clr-primary-dark);
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 500;
        }

        /* Team list */
        .team-list { display: flex; flex-direction: column; gap: 10px; }
        .team-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: var(--clr-gray-50);
            border-radius: var(--radius-md);
            border: 1px solid var(--clr-gray-100);
        }
        .team-item .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--clr-primary-light), var(--clr-primary));
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .team-item .info .name { font-weight: 600; font-size: 0.88rem; color: var(--clr-gray-800); }
        .team-item .info .role { font-size: 0.75rem; color: var(--clr-gray-400); }

        /* ===========================
           ANIMATIONS
        =========================== */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* ===========================
           RESPONSIVE
        =========================== */
        @media (max-width: 768px) {
            .navbar-nav { display: none; flex-direction: column; position: absolute; top: 68px; left: 0; right: 0; background: white; padding: 12px 16px; border-bottom: 1px solid var(--clr-gray-100); box-shadow: var(--shadow-md); gap: 4px; }
            .navbar-nav.open { display: flex; }
            .navbar-toggle { display: flex; }
            .footer-grid { grid-template-columns: 1fr; gap: 32px; }
            .footer-bottom { flex-direction: column; gap: 8px; text-align: center; }
            .gizi-grid { grid-template-columns: repeat(3, 1fr); }
            .section-title { font-size: 1.6rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar" role="navigation" aria-label="Navigasi utama">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="navbar-brand" id="navbar-brand-link">
                <div class="navbar-brand-icon">
                    <img src="{{ asset('images/logo-mbg.png') }}" alt="Logo MBG">
                </div>
                <span>
                    <span class="brand-name">Dapur MBG Bekasi</span>
                    <span class="brand-sub">Portal Transparansi Publik</span>
                </span>
            </a>

            <div class="navbar-nav" id="navbar-nav">
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}" id="nav-jadwal">
                    📅 Jadwal Menu
                </a>
                <a href="{{ url('/tentang') }}" class="nav-link {{ request()->is('tentang') ? 'active' : '' }}" id="nav-tentang">
                    🏠 Tentang Dapur
                </a>
                <span class="nav-badge">Gratis & Transparan</span>
            </div>

            <button class="navbar-toggle" id="navbar-toggle" aria-label="Buka menu navigasi" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer" role="contentinfo">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-brand-logo">
                        <div class="footer-brand-logo-icon">
                            <img src="{{ asset('images/logo-mbg.png') }}" alt="Logo MBG">
                        </div>
                        <span>Dapur MBG Bekasi</span>
                    </div>
                    <p class="footer-desc">
                        Portal transparansi publik program Makan Bergizi Gratis (MBG). Kami berkomitmen menyajikan informasi distribusi makanan bergizi secara terbuka untuk masyarakat.
                    </p>
                </div>
                <div class="footer-col">
                    <p class="footer-col-title">Navigasi</p>
                    <ul>
                        <li><a href="{{ url('/') }}">Jadwal Menu</a></li>
                        <li><a href="{{ url('/tentang') }}">Tentang Dapur</a></li>
                        <li><a href="{{ url('/tentang') }}#staf">Tim Kami</a></li>
                        <li><a href="{{ url('/tentang') }}#sekolah">Sekolah Mitra</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <p class="footer-col-title">Informasi</p>
                    <ul>
                        <li><a href="#">Program MBG</a></li>
                        <li><a href="#">Standar Gizi</a></li>
                        <li><a href="#">Kontak Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© {{ date('Y') }} Dapur MBG Bekasi. Hak cipta dilindungi.</span>
                <span>Dibuat dengan <span class="heart">❤️</span> untuk generasi bergizi Indonesia</span>
            </div>
        </div>
    </footer>

    <script>
        // Navbar toggle mobile
        const toggle = document.getElementById('navbar-toggle');
        const nav    = document.getElementById('navbar-nav');
        toggle.addEventListener('click', () => {
            const isOpen = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen);
        });
        // Close nav when link clicked (mobile)
        nav.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => { nav.classList.remove('open'); });
        });
    </script>

    @stack('scripts')
</body>
</html>
