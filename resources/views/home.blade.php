@extends('layouts.app')

@section('title', 'Jadwal Menu Mingguan')
@section('meta_description', 'Pantau jadwal menu makan bergizi gratis harian untuk siswa sekolah di Bekasi. Transparansi penuh informasi gizi, tim dapur, dan distribusi.')

@push('styles')
<style>
    /* ===========================
       HERO SECTION
    =========================== */
    .hero {
        background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 100%);
        padding: 80px 24px 100px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--clr-gray-200);
    }
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2316a34a' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .hero::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 60px;
        background: var(--clr-primary-50);
        clip-path: ellipse(55% 100% at 50% 100%);
    }
    .hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        text-align: center;
        color: var(--clr-gray-900);
    }
    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        background: white;
        border: 1px solid var(--clr-primary-light);
        color: var(--clr-primary-dark);
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: var(--font-heading);
        letter-spacing: 0.05em;
        margin-bottom: 20px;
    }
    .hero h1 {
        font-family: var(--font-heading);
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 20px;
        letter-spacing: -0.02em;
    }
    .hero h1 span { color: var(--clr-primary); }
    .hero-desc {
        font-size: 1rem;
        opacity: 0.9;
        max-width: 560px;
        margin: 0 auto 32px;
        line-height: 1.7;
    }

    /* Stats bar */
    .stats-bar {
        display: flex;
        justify-content: center;
        gap: 40px;
        flex-wrap: wrap;
        margin-top: 8px;
    }
    .stat-item {
        text-align: center;
    }
    .stat-value {
        font-family: var(--font-heading);
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        color: var(--clr-primary);
    }
    .stat-label {
        font-size: 0.78rem;
        color: var(--clr-gray-500);
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }

    /* ===========================
       WEEK NAVIGATOR
    =========================== */
    .week-nav-section {
        padding: 32px 24px 0;
    }
    .week-nav {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
        border-radius: var(--radius-lg);
        padding: 16px 20px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--clr-gray-100);
        gap: 12px;
    }
    .week-nav-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: var(--clr-primary-50);
        color: var(--clr-primary);
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.875rem;
        font-family: var(--font-heading);
        transition: var(--transition);
        border: 1px solid var(--clr-primary-light);
    }
    .week-nav-btn:hover { background: var(--clr-primary); color: white; transform: none; }
    .week-nav-center { text-align: center; }
    .week-nav-center .week-label {
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 1rem;
        color: var(--clr-gray-900);
    }
    .week-nav-center .week-range {
        font-size: 0.8rem;
        color: var(--clr-gray-400);
        margin-top: 2px;
    }

    /* ===========================
       JADWAL GRID
    =========================== */
    .jadwal-section {
        padding: 24px;
    }
    .jadwal-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    .jadwal-card {
        background: white;
        border-radius: var(--radius-xl);
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: var(--transition);
        cursor: pointer;
        position: relative;
    }
    .jadwal-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--clr-gray-200);
    }
    .jadwal-card-header {
        padding: 16px 20px 12px;
        background: rgba(255,255,255,0.95);
        border-bottom: 1px solid var(--clr-gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: absolute;
        top: 0; left: 0; right: 0;
        z-index: 10;
        backdrop-filter: blur(8px);
    }
    .jadwal-card-day {
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--clr-primary-dark);
    }
    .jadwal-card-date {
        font-size: 0.78rem;
        color: var(--clr-gray-500);
        margin-top: 1px;
    }
    .jadwal-status {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        font-family: var(--font-heading);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .jadwal-status.selesai { background: var(--clr-gray-100); color: var(--clr-gray-500); }
    .jadwal-status.aktif { background: #dcfce7; color: var(--clr-primary-dark); animation: pulse 2s infinite; }
    .jadwal-card-body { padding: 16px 20px; }
    .jadwal-menu-name {
        font-family: var(--font-heading);
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--clr-gray-900);
        margin-bottom: 10px;
    }
    .jadwal-lauk-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 14px;
    }
    .jadwal-lauk-tag {
        padding: 3px 9px;
        background: var(--clr-primary-50);
        color: var(--clr-primary-dark);
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 500;
        border: 1px solid var(--clr-primary-light);
    }
    .jadwal-gizi-mini {
        display: flex;
        gap: 12px;
        padding: 10px 14px;
        background: var(--clr-gray-50);
        border-radius: var(--radius-md);
        margin-bottom: 12px;
    }
    .gizi-mini-item {
        flex: 1;
        text-align: center;
    }
    .gizi-mini-val {
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 1rem;
    }
    .gizi-mini-lbl { font-size: 0.65rem; color: var(--clr-gray-400); }
    .gizi-mini-item.kal .gizi-mini-val { color: var(--clr-secondary); }
    .gizi-mini-item.kar .gizi-mini-val { color: var(--clr-accent); }
    .gizi-mini-item.pro .gizi-mini-val { color: var(--clr-primary); }
    .jadwal-card-footer {
        padding: 0 20px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .jadwal-team {
        font-size: 0.78rem;
        color: var(--clr-gray-500);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .jadwal-cta {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--clr-primary);
        font-family: var(--font-heading);
        background: var(--clr-primary-50);
        padding: 6px 14px;
        border-radius: 20px;
        transition: var(--transition);
    }
    .jadwal-cta svg { width: 16px; height: 16px; transition: var(--transition); }
    .jadwal-card:hover .jadwal-cta { background: var(--clr-primary); color: white; }
    .jadwal-card:hover .jadwal-cta svg { transform: translateX(4px); }

    /* Kosong state */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px 24px;
        color: var(--clr-gray-400);
    }
    .empty-state .empty-icon { font-size: 3rem; margin-bottom: 16px; }
    .empty-state p { font-size: 1rem; }

    /* ===========================
       RESPONSIVE
    =========================== */
    @media (max-width: 640px) {
        .hero { padding: 48px 16px 64px; }
        .stats-bar { gap: 24px; }
        .week-nav { flex-wrap: wrap; justify-content: center; }
        .jadwal-section { padding: 16px; }
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero" aria-label="Selamat datang di Portal MBG">
    <div class="hero-inner">
        <div class="hero-tag">🍱 Program Makan Bergizi Gratis</div>
        <h1>Jadwal Menu <span>Makan Bergizi</span><br>Untuk Generasi Indonesia</h1>
        <p class="hero-desc">
            Pantau jadwal menu harian, informasi gizi, dan distribusi makanan bergizi ke sekolah mitra kami secara transparan dan real-time.
        </p>

        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value">{{ number_format($stats['total_porsi']) }}</div>
                <div class="stat-label">Porsi/Hari</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['sekolah_mitra'] }}</div>
                <div class="stat-label">Sekolah Mitra</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['staf_aktif'] }}</div>
                <div class="stat-label">Staf Aktif</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['hari_operasi'] }}</div>
                <div class="stat-label">Hari/Minggu</div>
            </div>
        </div>
    </div>
</section>

<!-- WEEK NAVIGATOR -->
<section class="week-nav-section" aria-label="Navigasi minggu">
    <div class="week-nav">
        <a href="{{ url('/?minggu=' . ($minggu - 1)) }}" class="week-nav-btn" id="btn-prev-week">
            ← Minggu Lalu
        </a>
        <div class="week-nav-center">
            <div class="week-label">
                {{ $minggu === 0 ? 'Minggu Ini' : ($minggu > 0 ? $minggu . ' Minggu Mendatang' : abs($minggu) . ' Minggu Lalu') }}
            </div>
            <div class="week-range">
                {{ $startOfWeek->translatedFormat('d M') }} – {{ $startOfWeek->copy()->endOfWeek()->translatedFormat('d M Y') }}
            </div>
        </div>
        <a href="{{ url('/?minggu=' . ($minggu + 1)) }}" class="week-nav-btn" id="btn-next-week">
            Minggu Depan →
        </a>
    </div>
</section>

<!-- JADWAL GRID -->
<section class="jadwal-section" aria-label="Daftar jadwal menu">
    <div class="jadwal-grid">

        @if(count($jadwalMingguIni) === 0)
            <div class="empty-state">
                <div class="empty-icon">📅</div>
                <p>Belum ada jadwal menu untuk minggu ini.<br>Silakan navigasi ke minggu lain.</p>
            </div>
        @else
            @foreach($jadwalMingguIni as $item)
            <article
                class="jadwal-card"
                id="card-menu-{{ $item['id'] }}"
                role="button"
                tabindex="0"
                aria-label="Lihat detail menu {{ $item['menu_nama'] }} hari {{ $item['hari'] }}"
                onclick="bukaModal({{ $item['id'] }})"
                onkeydown="if(event.key==='Enter'||event.key===' ')bukaModal({{ $item['id'] }})"
                data-menu='@json($item)'
            >
                <div class="jadwal-card-header">
                    <div>
                        <div class="jadwal-card-day">{{ $item['hari'] }}</div>
                        <div class="jadwal-card-date">
                            {{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d F Y') }}
                        </div>
                    </div>
                    <span class="jadwal-status {{ $item['status'] }}">
                        {{ $item['status'] === 'aktif' ? '● Aktif' : '✓ Selesai' }}
                    </span>
                </div>
                <div class="jadwal-card-image" style="height: 160px; width: 100%; overflow: hidden;">
                    @if($item['foto'])
                        <img src="{{ $item['foto'] }}" alt="{{ $item['menu_nama'] }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" class="card-img-zoom">
                    @else
                        <div style="width: 100%; height: 100%; background: var(--clr-gray-200); display: flex; align-items: center; justify-content: center; font-size: 2rem;">🍽️</div>
                    @endif
                </div>
                <div class="jadwal-card-body">
                    <div class="jadwal-menu-name">{{ $item['menu_nama'] }}</div>
                    <div class="jadwal-lauk-preview">
                        @foreach(array_slice($item['lauk'], 0, 3) as $lauk)
                            <span class="jadwal-lauk-tag">{{ $lauk }}</span>
                        @endforeach
                        @if(count($item['lauk']) > 3)
                            <span class="jadwal-lauk-tag">+{{ count($item['lauk']) - 3 }} lagi</span>
                        @endif
                    </div>
                    <div class="jadwal-gizi-mini">
                        <div class="gizi-mini-item kal">
                            <div class="gizi-mini-val">{{ $item['kalori'] }}</div>
                            <div class="gizi-mini-lbl">kcal</div>
                        </div>
                        <div class="gizi-mini-item kar">
                            <div class="gizi-mini-val">{{ $item['karbo'] }}g</div>
                            <div class="gizi-mini-lbl">Karbo</div>
                        </div>
                        <div class="gizi-mini-item pro">
                            <div class="gizi-mini-val">{{ $item['protein'] }}g</div>
                            <div class="gizi-mini-lbl">Protein</div>
                        </div>
                    </div>
                </div>
                <div class="jadwal-card-footer">
                    <span class="jadwal-team">
                        👨‍🍳 {{ $item['chef']['nama'] }}
                    </span>
                    <span class="jadwal-cta">
                        Lihat detail
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </article>
            @endforeach
        @endif

    </div>
</section>

<!-- ===========================
     MODAL DETAIL MENU
=========================== -->
<div class="modal-overlay" id="modal-detail" role="dialog" aria-modal="true" aria-labelledby="modal-title" onclick="tutupModal(event)">
    <div class="modal-box" id="modal-box">
        <div class="modal-header">
            <button class="modal-close" onclick="tutupModal()" id="modal-close-btn" aria-label="Tutup modal">✕</button>
            <div class="modal-date" id="modal-date"></div>
            <h2 class="modal-title" id="modal-title"></h2>
        </div>
        <div class="modal-image" style="height: 220px; width: 100%; overflow: hidden; background: var(--clr-gray-100); display: none;" id="modal-image-container">
            <img src="" id="modal-image" alt="Menu Photo" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div class="modal-body">
            <!-- Gizi -->
            <div>
                <div class="modal-section-label">
                    <span class="dot"></span> Informasi Gizi
                </div>
                <div class="gizi-grid">
                    <div class="gizi-card gizi-kalori">
                        <div class="value" id="modal-kalori">-</div>
                        <div class="label">kcal Kalori</div>
                    </div>
                    <div class="gizi-card gizi-karbo">
                        <div class="value" id="modal-karbo">-</div>
                        <div class="label">gram Karbo</div>
                    </div>
                    <div class="gizi-card gizi-protein">
                        <div class="value" id="modal-protein">-</div>
                        <div class="label">gram Protein</div>
                    </div>
                </div>
            </div>

            <!-- Lauk -->
            <div>
                <div class="modal-section-label">
                    <span class="dot" style="background:var(--clr-secondary)"></span> Lauk & Hidangan
                </div>
                <div class="lauk-list" id="modal-lauk"></div>
            </div>

            <!-- Tim Dapur -->
            <div>
                <div class="modal-section-label">
                    <span class="dot" style="background:var(--clr-accent)"></span> Tim Dapur & Distribusi
                </div>
                <div class="team-list" id="modal-team"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Data semua menu (untuk modal)
    const allMenus = @json($jadwal);

    function bukaModal(id) {
        const menu = allMenus.find(m => m.id === id);
        if (!menu) return;

        // Set tanggal
        const tgl = new Date(menu.tanggal);
        const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('modal-date').innerHTML = '📅 ' + tgl.toLocaleDateString('id-ID', opts);

        // Set judul
        document.getElementById('modal-title').textContent = menu.menu_nama;

        // Set gizi
        document.getElementById('modal-kalori').textContent = menu.kalori;
        document.getElementById('modal-karbo').textContent  = menu.karbo + 'g';
        document.getElementById('modal-protein').textContent = menu.protein + 'g';

        // Set lauk
        const laukEl = document.getElementById('modal-lauk');
        laukEl.innerHTML = menu.lauk.map(l => `<span class="lauk-tag">${l}</span>`).join('');

        // Set Image
        const imgContainer = document.getElementById('modal-image-container');
        const imgEl = document.getElementById('modal-image');
        if (menu.foto) {
            imgEl.src = menu.foto;
            imgContainer.style.display = 'block';
        } else {
            imgContainer.style.display = 'none';
        }

        // Set team
        const teamEl = document.getElementById('modal-team');
        teamEl.innerHTML = `
            <div class="team-item">
                <div class="avatar">👨‍🍳</div>
                <div class="info">
                    <div class="name">${menu.chef.nama}</div>
                    <div class="role">${menu.chef.posisi}</div>
                </div>
            </div>
            <div class="team-item">
                <div class="avatar">🚐</div>
                <div class="info">
                    <div class="name">${menu.supir.nama}</div>
                    <div class="role">${menu.supir.posisi}</div>
                </div>
            </div>
        `;

        // Buka modal
        const overlay = document.getElementById('modal-detail');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';

        // Focus ke modal untuk aksesibilitas
        setTimeout(() => document.getElementById('modal-close-btn').focus(), 100);
    }

    function tutupModal(event) {
        if (event && event.target !== document.getElementById('modal-detail')) return;
        document.getElementById('modal-detail').classList.remove('open');
        document.body.style.overflow = '';
    }

    // Tutup dengan tombol Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.getElementById('modal-detail').classList.remove('open');
            document.body.style.overflow = '';
        }
    });

    // Tombol close
    document.getElementById('modal-close-btn').addEventListener('click', () => {
        document.getElementById('modal-detail').classList.remove('open');
        document.body.style.overflow = '';
    });
</script>
@endpush
