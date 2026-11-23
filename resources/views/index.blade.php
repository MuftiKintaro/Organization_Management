<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM Esport - Campus Gaming Hub</title>

    <!-- Sambungkan ke CSS di folder public/ -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    <!-- HEADER / NAVIGASI UTAMA -->
    <header class="header">
        <div class="container navbar">

            <div class="logo">
                <span class="logo-icon">🎮</span> CYBER ESPORT
            </div>

            <nav>
                <ul class="nav-menu">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#anggota">Divisi & Roster</a></li>
                    <li><a href="#program">Program Kerja</a></li>
                    <li><a href="#kegiatan">Kegiatan</a></li>
                    <li><a href="#laporan">Laporan</a></li>
                    <li><a href="{{ url('/pengurus') }}" style="color: #06b6d4; font-weight: bold;">👤 Pengurus (MVC)</a></li>
                    <li><button id="open-login-btn" class="button button-outline btn-sm">Login Member</button></li>
                </ul>
            </nav>

        </div>
    </header>


    <!-- KANDUNGAN UTAMA -->
    <main>

        <!-- HERO SECTION -->
        <section id="beranda" class="hero">
            <div class="container hero-content">

                <div class="hero-text">
                    <span class="tag">Unit Kegiatan Mahasiswa Esports</span>
                    <h1>
                        Wadah Bakat & Prestasi Gaming
                        <span>Mahasiswa</span>
                    </h1>
                    <p>
                        Pusat pengelolaan divisi game, turnamen kampus, latihan rutin (scrim), serta pengembangan talent shoutcaster & media streaming secara profesional.
                    </p>
                    <div class="hero-buttons">
                        <a href="#program" class="button">Lihat Turnamen</a>
                        <a href="{{ url('/pengurus') }}" class="button button-outline">Struktur Pengurus (MVC)</a>
                    </div>
                </div>

                <div class="hero-visual">
                    <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80" alt="Esports Gaming Arena" class="hero-img">
                    <div class="hero-card-floating">
                        <div class="stat-box">
                            <strong>20</strong>
                            <span>Player</span>
                        </div>
                        <div class="stat-box">
                            <strong>3</strong>
                            <span>Divisi Game</span>
                        </div>
                        <div class="stat-box">
                            <strong>6</strong>
                            <span>Trophy Kampus</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- ANGGOTA DAN DIVISI GAME -->
        <section id="anggota" class="section">
            <div class="container">

                <div class="section-heading">
                    <span class="tag">Game Division</span>
                    <h2>Divisi Game & Talent</h2>
                    <p>
                        Daftar divisi game kompetitif dan tim official UKM Esport kampus.
                    </p>
                </div>

                <div class="card-grid">

                    <article class="card">
                        <img src="https://images.unsplash.com/photo-1538481199705-c710c4e965fc?auto=format&fit=crop&w=600&q=80" alt="Divisi PC Gaming" class="card-img">
                        <div class="card-body">
                            <div class="icon">🎯</div>
                            <h3>Divisi Valorant (FPS)</h3>
                            <p>
                                Fokus pada taktik, ketangkasan aiming, dan komunikasi tim untuk kompetisi PC FPS antar perguruan tinggi.
                            </p>
                        </div>
                    </article>

                    <article class="card">
                        <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=600&q=80" alt="Divisi Mobile Gaming" class="card-img">
                        <div class="card-body">
                            <div class="icon">📱</div>
                            <h3>Divisi MLBB (MOBA Mobile)</h3>
                            <p>
                                Wadah bagi player Mobile Legends untuk mengasah draft-pick, macro play, dan strategi liga kampus.
                            </p>
                        </div>
                    </article>

                    <article class="card">
                        <img src="https://images.unsplash.com/photo-1561736778-92e52a7769ef?auto=format&fit=crop&w=600&q=80" alt="Divisi Caster & Streamer" class="card-img">
                        <div class="card-body">
                            <div class="icon">🎙️</div>
                            <h3>Divisi Caster & Content Creator</h3>
                            <p>
                                Melatih bakat shoutcaster, OBS streaming operator, dan pembuat konten kreatif esports kampus.
                            </p>
                        </div>
                    </article>

                </div>

            </div>
        </section>


        <!-- PROFIL PENGURUS (DATA MVC) -->
        <section id="pengurus" class="section section-light">
            <div class="container">
                <div class="section-heading">
                    <span class="tag">Struktur Kepengurusan</span>
                    <h2>Profil Ketua & Pengurus (MVC)</h2>
                    <p>
                        Data pengurus dan program kerja yang dikelola dengan arsitektur Model-View-Controller.
                    </p>
                </div>

                <div style="background: #131b2e; border: 1px solid #1e293b; border-radius: 16px; padding: 30px; max-width: 650px; margin: 0 auto; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
                    <img src="{{ asset('asset/fotobudi.jpeg') }}" alt="Foto Budi Anantha" style="width: 120px; height: 120px; border-radius: 50%; border: 3px solid #06b6d4; object-fit: cover; margin: 0 auto 15px auto; box-shadow: 0 0 15px rgba(6,182,212,0.3);">
                    <h3 style="margin: 0 0 5px 0; color: #f8fafc; font-size: 1.6rem;">Budi Anantha</h3>
                    <p style="color: #38bdf8; font-weight: 600; font-size: 0.95rem; margin: 0 0 12px 0;">Ketua Umum UKM Esports (Periode 2026 - 2027)</p>
                    <p style="color: #94a3b8; font-size: 0.92rem; line-height: 1.6; margin: 0 0 20px 0;">
                        Ketua Umum UKM Esports periode 2026/2027 yang berfokus pada pembinaan talenta mahasiswa di bidang esports nasional.
                    </p>
                    <a href="{{ url('/pengurus') }}" class="button">Buka Halaman Pengurus & Proker (MVC Lengkap) →</a>
                </div>
            </div>
        </section>


        <!-- PROGRAM KERJA (DARI DATABASE MYSQL VIA ELOQUENT ORM) -->
        <section id="program" class="section">
            <div class="container">
                <div class="section-heading">
                    <span class="tag">Agenda Esports</span>
                    <h2>Program Kerja & Turnamen</h2>
                    <p>
                        Jadwal kejuaraan, coaching clinic, dan event utama UKM Esport.
                        <a href="{{ url('/pengurus') }}" style="color: #06b6d4; text-decoration: none; font-weight: bold; margin-left: 8px;">→ Kelola & Lihat Detail Pengurus</a>
                    </p>
                </div>

                <div class="card-grid">
                    @forelse ($programList as $item)
                        @php
                            $statusText = $item->status ?? 'Perencanaan';
                            $statusClass = 'status-planned';
                            if ($statusText === 'Sedang Berjalan' || $statusText === 'Berjalan') {
                                $statusClass = 'status-running';
                            } elseif ($statusText === 'Terlaksana' || $statusText === 'Selesai') {
                                $statusClass = 'status-done';
                            }
                        @endphp
                        <article class="card">
                            <div class="card-body">
                                <span class="status {{ $statusClass }}">{{ $statusText }}</span>
                                <h3>{{ $item->icon ?? '🎮' }} {{ $item->judul }}</h3>
                                <p>{{ $item->deskripsi }}</p>
                                @if($item->tanggal)
                                    <p class="date">📅 {{ $item->tanggal }}</p>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p style="grid-column: 1/-1; text-align: center; color: #94a3b8;">Belum ada data program kerja di database.</p>
                    @endforelse
                </div>

            </div>
        </section>


        <!-- KEGIATAN -->
        <section id="kegiatan" class="section">
            <div class="container">

                <div class="section-heading">
                    <span class="tag">Aktivitas Rutin</span>
                    <h2>Kegiatan & Sparring</h2>
                    <p>
                        Jadwal latihan tanding (scrimmage) dan workshop mingguan.
                    </p>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px; max-width: 850px; margin: 0 auto;">

                    <article style="display: flex; align-items: center; gap: 20px; background: #1e293b; border: 1px solid #334155; padding: 20px; border-radius: 14px;">
                        <div style="background: #0f172a; border: 1px solid #06b6d4; border-radius: 10px; padding: 12px 18px; text-align: center; min-width: 75px;">
                            <strong style="display: block; font-size: 22px; color: #06b6d4; line-height: 1.1;">02</strong>
                            <span style="font-size: 12px; font-weight: bold; color: #94a3b8;">OKT</span>
                        </div>
                        <div>
                            <h3 style="margin: 0 0 6px 0; font-size: 18px; color: #f8fafc;">Weekly Scrim: UKM Esport vs Universitas Tetangga</h3>
                            <p style="margin: 0; font-size: 14px; color: #94a3b8;">
                                Latihan tanding persahabatan divisi Valorant dan MLBB untuk menguji chemistry tim.
                            </p>
                        </div>
                    </article>

                    <article style="display: flex; align-items: center; gap: 20px; background: #1e293b; border: 1px solid #334155; padding: 20px; border-radius: 14px;">
                        <div style="background: #0f172a; border: 1px solid #06b6d4; border-radius: 10px; padding: 12px 18px; text-align: center; min-width: 75px;">
                            <strong style="display: block; font-size: 22px; color: #06b6d4; line-height: 1.1;">12</strong>
                            <span style="font-size: 12px; font-weight: bold; color: #94a3b8;">OKT</span>
                        </div>
                        <div>
                            <h3 style="margin: 0 0 6px 0; font-size: 18px; color: #f8fafc;">Workshop Shoutcasting & Live Production</h3>
                            <p style="margin: 0; font-size: 14px; color: #94a3b8;">
                                Pelatihan dasar menjadi shoutcaster esports profesional dan penggunaan software streaming OBS.
                            </p>
                        </div>
                    </article>

                </div>

            </div>
        </section>


        <!-- LAPORAN -->
        <section id="laporan" class="section section-light">
            <div class="container">

                <div class="section-heading">
                    <span class="tag">Transparansi UKM</span>
                    <h2>Laporan & Rekap Prestasi</h2>
                    <p>
                        Dokumentasi pencapaian trophy, laporan kas, dan evaluasi pengurus.
                    </p>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; background: #1e293b; border: 1px solid #334155; padding: 28px 32px; border-radius: 16px;">
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 20px; color: #f8fafc;">Laporan Kinerja & Prestasi Turnamen</h3>
                        <p style="margin: 0; font-size: 14px; color: #94a3b8;">
                            Arsip resmi pencapaian juara tim kampus, laporan keuangan operasional, serta statistik per divisi.
                        </p>
                    </div>
                    <a href="{{ url('/dashboard') }}" class="button">
                        Lihat Laporan
                    </a>
                </div>

            </div>
        </section>

    </main>


    <!-- MODAL POP-UP LOGIN -->
    <div id="login-modal" class="modal-overlay">
        <div class="modal-content">
            <button type="button" id="close-login-btn" class="modal-close">&times;</button>

            <div class="modal-header">
                <span style="font-size: 32px; display: block; margin-bottom: 8px;">🎮</span>
                <h2>Portal Login Member</h2>
                <p>Khusus Pengurus & Player Terdaftar</p>
            </div>

            <!-- Role Switcher -->
            <div class="role-selector">
                <button type="button" class="role-btn active" data-role="ketua">👑 Ketua / Pengurus</button>
                <button type="button" class="role-btn" data-role="player">🎮 Player</button>
            </div>

            <!-- Form Input -->
            <form id="login-form">
                <div class="form-group">
                    <label for="login-id" id="label-id">NIM / ID Ketua Umum</label>
                    <input type="text" id="login-id" placeholder="Contoh: 230101001" required>
                </div>

                <div class="form-group">
                    <label for="login-password">Password / PIN Portal</label>
                    <input type="password" id="login-password" placeholder="••••••••" required>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #94a3b8; margin-bottom: 14px;">
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                        <input type="checkbox"> Ingat Saya
                    </label>
                    <a href="#" style="color: #06b6d4;" onclick="alert('Silakan hubungi Divisi IT/Pengurus untuk reset PIN.'); return false;">Lupa PIN?</a>
                </div>

                <button type="submit" class="button button-full">Masuk Portal</button>
            </form>

            <div id="login-message" class="login-message"></div>
        </div>
    </div>


    <!-- FOOTER LENGKAP -->
    <footer class="footer">
        <div class="container footer-content">
            <div class="footer-brand">
                <h3>🎮 CYBER ESPORT UKM</h3>
                <p>Wadah Resmi Pengembangan Potensi Esports & Gaming Mahasiswa Kampus.</p>
            </div>
            <div class="footer-links">
                <h4>Navigasi Cepat</h4>
                <a href="#beranda">Beranda</a>
                <a href="#anggota">Divisi Game</a>
                <a href="#program">Turnamen</a>
                <a href="{{ url('/pengurus') }}">Pengurus & Proker (MVC)</a>
                <a href="{{ url('/dashboard') }}">Portal Dashboard</a>
            </div>
            <div class="footer-copy">
                <p>&copy; 2026 Cyber Esports UKM. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('script.js') }}"></script>
</body>

</html>
