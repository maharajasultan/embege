@extends('layouts.app')

@section('title', 'Tentang Dapur MBG Bekasi')
@section('meta_description', 'Kenali Dapur MBG Bekasi — profil, visi misi, tim staf, dan sekolah mitra program Makan Bergizi Gratis.')

@push('styles')
<style>
    /* ===========================
       HERO TENTANG
    =========================== */
    .hero-tentang {
        background: linear-gradient(135deg, #f8fafc 0%, #f0f9ff 100%);
        padding: 80px 24px 100px;
        position: relative;
        overflow: hidden;
        color: var(--clr-gray-900);
        text-align: center;
        border-bottom: 1px solid var(--clr-gray-200);
    }
    .hero-tentang::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230ea5e9' fill-opacity='0.03'%3E%3Cpath d='M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10s-10-4.477-10-10 4.477-10 10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S0 25.523 0 20s4.477-10 10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .hero-tentang::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 60px;
        background: var(--clr-primary-50);
        clip-path: ellipse(55% 100% at 50% 100%);
    }
    .hero-tentang-inner {
        max-width: 700px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    .hero-tentang-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        background: white;
        border: 1px solid #bae6fd;
        color: #0369a1;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: var(--font-heading);
        margin-bottom: 20px;
    }
    .hero-tentang h1 {
        font-family: var(--font-heading);
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 16px;
        letter-spacing: -0.02em;
    }
    .hero-tentang h1 span { color: var(--clr-accent); }
    .hero-tentang-desc {
        font-size: 1rem;
        opacity: 0.85;
        line-height: 1.7;
    }

    /* ===========================
       PROFIL SECTION
    =========================== */
    .profil-section {
        padding: 60px 24px;
    }
    .profil-inner {
        max-width: 1200px;
        margin: 0 auto;
    }
    .profil-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        align-items: start;
    }
    .profil-card {
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--clr-gray-200);
        overflow: hidden;
    }
    .profil-card-img {
        width: 100%;
        height: 220px;
        background: var(--clr-gray-100);
    }
    .profil-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profil-card-body {
        padding: 32px;
    }
    .profil-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: var(--font-heading);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--clr-gray-900);
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--clr-primary-50);
    }
    .profil-card-title .icon {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, var(--clr-primary), #22c55e);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .profil-info-list { display: flex; flex-direction: column; gap: 14px; }
    .profil-info-item { display: flex; gap: 12px; }
    .profil-info-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--clr-gray-400);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        min-width: 80px;
        padding-top: 2px;
        font-family: var(--font-heading);
    }
    .profil-info-value {
        font-size: 0.9rem;
        color: var(--clr-gray-700);
        line-height: 1.5;
    }
    .profil-info-value a { color: var(--clr-primary); }

    /* Visi misi */
    .visi-box {
        background: linear-gradient(135deg, var(--clr-primary-50), #dcfce7);
        border: 1px solid var(--clr-primary-light);
        border-radius: var(--radius-md);
        padding: 18px;
        margin-bottom: 16px;
    }
    .visi-box .visi-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--clr-primary-dark);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 6px;
        font-family: var(--font-heading);
    }
    .visi-box p { font-size: 0.875rem; color: var(--clr-gray-700); line-height: 1.65; font-style: italic; }
    .misi-list { display: flex; flex-direction: column; gap: 10px; }
    .misi-item {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        font-size: 0.875rem;
        color: var(--clr-gray-700);
        line-height: 1.55;
    }
    .misi-num {
        width: 22px; height: 22px;
        background: var(--clr-primary);
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ===========================
       STAF SECTION
    =========================== */
    .staf-section {
        padding: 60px 24px;
        background: white;
    }
    .staf-inner { max-width: 1200px; margin: 0 auto; }
    .staf-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }
    .staf-card {
        background: white;
        border: 1px solid rgba(0,0,0,0.03);
        border-radius: var(--radius-xl);
        padding: 32px 20px;
        text-align: center;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }
    .staf-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--clr-gray-200);
    }
    .staf-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        position: relative;
    }
    .staf-avatar-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 16px;
        border: 3px solid var(--clr-gray-100);
    }
    .staf-name {
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--clr-gray-900);
        margin-bottom: 4px;
    }
    .staf-posisi {
        display: inline-flex;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        font-family: var(--font-heading);
        margin-bottom: 8px;
    }
    .staf-bio {
        font-size: 0.78rem;
        color: var(--clr-gray-400);
        line-height: 1.5;
    }

    /* ===========================
       SEKOLAH SECTION
    =========================== */
    .sekolah-section { padding: 60px 24px; }
    .sekolah-inner { max-width: 1200px; margin: 0 auto; }
    .sekolah-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }
    .sekolah-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 0;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .sekolah-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--clr-gray-200);
    }
    .sekolah-card-img {
        height: 140px;
        width: 100%;
        background: var(--clr-gray-100);
        overflow: hidden;
        position: relative;
    }
    .sekolah-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .sekolah-card:hover .sekolah-card-img img { transform: scale(1.05); }
    .sekolah-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }
    .sekolah-card-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .sekolah-icon {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, var(--clr-primary-light), #bbf7d0);
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .sekolah-nama {
        font-family: var(--font-heading);
        font-size: 1rem;
        font-weight: 700;
        color: var(--clr-gray-900);
        line-height: 1.3;
    }
    .sekolah-alamat {
        font-size: 0.8rem;
        color: var(--clr-gray-500);
        line-height: 1.55;
        display: flex;
        align-items: flex-start;
        gap: 5px;
    }
    .sekolah-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid var(--clr-gray-100);
    }
    .sekolah-kuota {
        font-family: var(--font-heading);
        font-size: 0.82rem;
        color: var(--clr-gray-500);
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .sekolah-kuota strong { color: var(--clr-primary); font-size: 1rem; }

    /* ===========================
       RESPONSIVE
    =========================== */
    @media (max-width: 768px) {
        .profil-grid { grid-template-columns: 1fr; gap: 24px; }
        .profil-section, .staf-section, .sekolah-section { padding: 40px 16px; }
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero-tentang" aria-label="Tentang Dapur MBG Bekasi">
    <div class="hero-tentang-inner">
        <div class="hero-tentang-tag">🏠 Tentang Kami</div>
        <h1>Mengenal <span>Dapur MBG</span><br>{{ $profil['nama'] }}</h1>
        <p class="hero-tentang-desc">
            Transparansi dan kepercayaan publik adalah landasan kami. Kenali lebih dekat tim, profil, dan mitra sekolah yang kami layani.
        </p>
    </div>
</section>

<!-- PROFIL -->
<section class="profil-section" aria-labelledby="heading-profil">
    <div class="profil-inner">
        <div class="section-header">
            <div class="section-tag">🏛️ Profil Dapur</div>
            <h2 class="section-title" id="heading-profil">{{ $profil['nama'] }}</h2>
            <p class="section-subtitle">Beroperasi sejak {{ $profil['berdiri'] }}, kami berkomitmen menyajikan makanan bergizi setiap hari untuk siswa Bekasi.</p>
        </div>

        <div class="profil-grid">
            <!-- Info Dapur -->
            <div class="profil-card">
                <div class="profil-card-img">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745a872f?auto=format&fit=crop&w=800&q=80" alt="Foto Dapur MBG">
                </div>
                <div class="profil-card-body">
                    <div class="profil-card-title">
                        <div class="icon">📍</div>
                        Informasi Dapur
                    </div>
                    <div class="profil-info-list">
                        <div class="profil-info-item">
                            <span class="profil-info-label">Nama</span>
                            <span class="profil-info-value">{{ $profil['nama'] }}</span>
                        </div>
                        <div class="profil-info-item">
                            <span class="profil-info-label">Lokasi</span>
                            <span class="profil-info-value">{{ $profil['lokasi'] }}</span>
                        </div>
                        <div class="profil-info-item">
                            <span class="profil-info-label">Telepon</span>
                            <span class="profil-info-value"><a href="tel:{{ $profil['telepon'] }}">{{ $profil['telepon'] }}</a></span>
                        </div>
                        <div class="profil-info-item">
                            <span class="profil-info-label">Email</span>
                            <span class="profil-info-value"><a href="mailto:{{ $profil['email'] }}">{{ $profil['email'] }}</a></span>
                        </div>
                        <div class="profil-info-item">
                            <span class="profil-info-label">Kapasitas</span>
                            <span class="profil-info-value">{{ $profil['kapasitas'] }}</span>
                        </div>
                        <div class="profil-info-item">
                            <span class="profil-info-label">Berdiri</span>
                            <span class="profil-info-value">{{ $profil['berdiri'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visi & Misi -->
            <div class="profil-card">
                <div class="profil-card-img">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=80" alt="Visi Misi Dapur MBG">
                </div>
                <div class="profil-card-body">
                    <div class="profil-card-title">
                        <div class="icon">🎯</div>
                        Visi & Misi
                    </div>
                    <div class="visi-box">
                        <div class="visi-label">✨ Visi</div>
                        <p>{{ $profil['visi'] }}</p>
                    </div>
                    <div class="misi-list">
                        @foreach($profil['misi'] as $i => $item)
                        <div class="misi-item">
                            <span class="misi-num">{{ $i + 1 }}</span>
                            <span>{{ $item }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GALERI STAF -->
<section class="staf-section" id="staf" aria-labelledby="heading-staf">
    <div class="staf-inner">
        <div class="section-header">
            <div class="section-tag">👥 Tim Kami</div>
            <h2 class="section-title" id="heading-staf">Galeri Staf & Karyawan</h2>
            <p class="section-subtitle">Kenali para profesional berdedikasi di balik setiap porsi makanan bergizi yang kami sajikan.</p>
        </div>

        <div class="staf-grid">
            @foreach($staf as $karyawan)
            @php
                $posisiWarna = match(true) {
                    str_contains($karyawan['posisi'], 'Manajer') => ['bg' => '#dcfce7', 'text' => '#14532d'],
                    str_contains($karyawan['posisi'], 'Head Chef') => ['bg' => '#fed7aa', 'text' => '#9a3412'],
                    str_contains($karyawan['posisi'], 'Chef') => ['bg' => '#fce7f3', 'text' => '#9d174d'],
                    str_contains($karyawan['posisi'], 'Gizi') => ['bg' => '#e0f2fe', 'text' => '#0c4a6e'],
                    str_contains($karyawan['posisi'], 'Driver') => ['bg' => '#fef9c3', 'text' => '#713f12'],
                    default => ['bg' => '#f1f5f9', 'text' => '#475569'],
                };
            @endphp
            <article class="staf-card" id="staf-{{ $karyawan['id'] }}">
                @if(isset($karyawan['foto']) && $karyawan['foto'])
                <div class="staf-avatar" style="padding: 0;">
                    <img src="{{ $karyawan['foto'] }}" alt="{{ $karyawan['nama'] }}" class="staf-avatar-img" style="margin: 0; width: 100%; height: 100%; object-fit: cover; border: 3px solid {{ $posisiWarna['bg'] }}; border-radius: 50%;">
                </div>
                @else
                <div class="staf-avatar" style="background: linear-gradient(135deg, {{ $karyawan['warna'] ?? '#ccc' }}22, {{ $karyawan['warna'] ?? '#ccc' }}44);">
                    {{ $karyawan['emoji'] ?? '👤' }}
                </div>
                @endif
                <div class="staf-name">{{ $karyawan['nama'] }}</div>
                <span class="staf-posisi" style="background: {{ $posisiWarna['bg'] }}; color: {{ $posisiWarna['text'] }};">
                    {{ $karyawan['posisi'] }}
                </span>
                <p class="staf-bio">{{ $karyawan['bio'] }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- SEKOLAH MITRA -->
<section class="sekolah-section" id="sekolah" aria-labelledby="heading-sekolah">
    <div class="sekolah-inner">
        <div class="section-header">
            <div class="section-tag">🏫 Mitra Kami</div>
            <h2 class="section-title" id="heading-sekolah">Sekolah Mitra MBG</h2>
            <p class="section-subtitle">{{ count($sekolah) }} institusi pendidikan yang menerima distribusi makanan bergizi dari dapur kami setiap hari.</p>
        </div>

        <div class="sekolah-grid">
            @foreach($sekolah as $s)
            @php
                $tingkatBadge = match($s['tingkat']) {
                    'SD'  => ['bg' => '#dcfce7', 'text' => '#14532d'],
                    'SMP' => ['bg' => '#e0f2fe', 'text' => '#0c4a6e'],
                    'SMA' => ['bg' => '#ede9fe', 'text' => '#4c1d95'],
                    default => ['bg' => '#f1f5f9', 'text' => '#475569'],
                };
            @endphp
            <article class="sekolah-card" id="sekolah-{{ $s['id'] }}">
                <div class="sekolah-card-img">
                    @if(isset($s['foto']) && $s['foto'])
                        <img src="{{ $s['foto'] }}" alt="{{ $s['nama'] }}">
                    @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, {{ $tingkatBadge['bg'] }}, white);">
                            <span style="font-size:3rem; opacity:0.5;">{{ $s['emoji'] }}</span>
                        </div>
                    @endif
                </div>
                <div class="sekolah-card-body">
                    <div class="sekolah-card-header">
                        <div>
                            <div class="sekolah-nama">{{ $s['nama'] }}</div>
                            <span class="badge" style="background:{{ $tingkatBadge['bg'] }};color:{{ $tingkatBadge['text'] }};margin-top:6px;">
                                Tingkat {{ $s['tingkat'] }}
                            </span>
                        </div>
                    </div>
                    <div class="sekolah-alamat" style="flex: 1;">
                        📍 {{ $s['alamat'] }}
                    </div>
                    <div class="sekolah-card-footer">
                        <span class="sekolah-kuota">
                            🍽️ <strong>{{ number_format($s['kuota']) }}</strong> porsi/hari
                        </span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

@endsection
