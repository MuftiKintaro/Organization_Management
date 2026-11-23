<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM Esports Hub - Pengurus & Proker (Laravel ORM)</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <style>
        html { scroll-behavior: smooth; }
        .neon-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .neon-card:hover {
            transform: translateY(-5px);
            border-color: #06b6d4 !important;
            box-shadow: 0 12px 30px rgba(6, 182, 212, 0.25) !important;
        }
        .bph-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            transition: all 0.25s ease;
        }
        .bph-card:hover {
            transform: translateY(-4px);
            border-color: #38bdf8;
            box-shadow: 0 8px 20px rgba(56, 189, 248, 0.2);
        }
        .stat-pill {
            background: #1e293b;
            border: 1px solid #334155;
            padding: 12px 18px;
            border-radius: 12px;
            text-align: center;
            flex: 1;
            min-width: 130px;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; color: #000000 !important; }
        }
    </style>
</head>
<body style="background-color: #0b0f19; color: #f8fafc; font-family: 'Segoe UI', sans-serif; padding: 40px 20px; margin: 0;">

    <div style="max-width: 920px; margin: 0 auto; background: #131b2e; border: 1px solid #1e293b; border-radius: 16px; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.6);">

        <!-- HEADER NAVIGASI & AKSI CEPAT -->
        <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; padding-bottom: 16px; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.6rem;">🎮</span>
                <div>
                    <h2 style="color: #06b6d4; margin: 0; font-size: 1.35rem;">CYBER ESPORT UKM</h2>
                    <span style="color: #94a3b8; font-size: 0.8rem; letter-spacing: 0.5px;">LARAVEL MVC & ELOQUENT ORM</span>
                </div>
            </div>

            <div style="font-size: 0.88rem; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                <a href="{{ url('/') }}" style="color: #94a3b8; text-decoration: none; font-weight: 500;">🏠 Landing Page</a>
                <a href="{{ url('/dashboard') }}" style="color: #94a3b8; text-decoration: none; font-weight: 500;">📊 Dashboard</a>
                <button onclick="window.print()" style="background: #0f172a; border: 1px solid #334155; color: #94a3b8; padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; cursor: pointer;">
                    🖨️ Cetak
                </button>
            </div>
        </div>

        <!-- 1. PROFIL UTAMA KETUA UMUM -->
        <div style="text-align: center; margin-bottom: 35px; background: radial-gradient(circle at top, rgba(6,182,212,0.1) 0%, transparent 70%); padding: 25px 15px; border-radius: 16px;">
            <img src="{{ $profileData['avatar'] }}" alt="Foto {{ $profileData['nama'] }}" style="width: 125px; height: 125px; border-radius: 50%; border: 3px solid #06b6d4; object-fit: cover; margin: 0 auto 12px auto; box-shadow: 0 0 20px rgba(6,182,212,0.35);">
            <h1 style="margin: 4px 0; color: #f8fafc; font-size: 1.85rem;">{{ $profileData['nama'] }}</h1>
            <p style="color: #38bdf8; font-weight: 600; font-size: 1rem; margin: 0 0 10px 0;">👑 Ketua Umum UKM Esports (Periode {{ $profileData['periode'] }})</p>
            <p style="color: #94a3b8; max-width: 580px; margin: 0 auto; line-height: 1.6; font-size: 0.94rem;">
                {{ $profileData['profil'] }}
            </p>
        </div>

        <!-- 2. STRUKTUR LENGKAP BADAN PENGURUS HARIAN (BPH) -->
        <div style="margin-bottom: 35px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="color: #f8fafc; margin: 0; font-size: 1.15rem;">👥 Jajaran Badan Pengurus Harian (BPH)</h3>
                <span style="color: #06b6d4; font-size: 0.8rem; font-weight: 600;">Dikelola via ProgramController</span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                @foreach ($bphList as $bph)
                    <div class="bph-card">
                        <img src="{{ $bph['avatar'] }}" alt="{{ $bph['nama'] }}" style="width: 65px; height: 65px; border-radius: 50%; border: 2px solid #06b6d4; object-fit: cover; margin: 0 auto 10px auto;">
                        <span style="display: inline-block; background: #0f172a; border: 1px solid #334155; color: #38bdf8; font-size: 0.7rem; font-weight: bold; padding: 2px 8px; border-radius: 12px; margin-bottom: 6px;">
                            {{ $bph['badge'] }}
                        </span>
                        <h4 style="margin: 0 0 4px 0; color: #f8fafc; font-size: 0.95rem;">{{ $bph['nama'] }}</h4>
                        <p style="margin: 0 0 4px 0; color: #06b6d4; font-size: 0.8rem; font-weight: 600;">{{ $bph['jabatan'] }}</p>
                        <p style="margin: 0; color: #64748b; font-size: 0.75rem;">NIM: {{ $bph['nim'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 3. METRIK STATISTIK PROKER -->
        <div style="border-top: 1px solid #1e293b; padding-top: 25px; margin-bottom: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 8px;">
                <h3 style="color: #f8fafc; margin: 0; font-size: 1.15rem;">📊 Statistik & Ketercapaian Program Kerja</h3>
                <span style="color: #38bdf8; font-size: 0.85rem; font-weight: bold;">Progres Selesai: {{ $stats['percentage'] }}%</span>
            </div>

            <div style="width: 100%; height: 8px; background: #1e293b; border-radius: 10px; overflow: hidden; margin-bottom: 16px;">
                <div style="width: {{ $stats['percentage'] }}%; height: 100%; background: linear-gradient(90deg, #06b6d4, #10b981); border-radius: 10px;"></div>
            </div>

            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <div class="stat-pill">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #f8fafc;">{{ $stats['total'] }}</div>
                    <div style="font-size: 0.78rem; color: #94a3b8;">Total Proker</div>
                </div>
                <div class="stat-pill" style="border-color: rgba(6,182,212,0.4);">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #06b6d4;">{{ $stats['running'] }}</div>
                    <div style="font-size: 0.78rem; color: #06b6d4;">🔵 Sedang Berjalan</div>
                </div>
                <div class="stat-pill" style="border-color: rgba(245,158,11,0.4);">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #f59e0b;">{{ $stats['planned'] }}</div>
                    <div style="font-size: 0.78rem; color: #f59e0b;">🟡 Perencanaan</div>
                </div>
                <div class="stat-pill" style="border-color: rgba(16,185,129,0.4);">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #10b981;">{{ $stats['done'] }}</div>
                    <div style="font-size: 0.78rem; color: #10b981;">🟢 Terlaksana</div>
                </div>
            </div>
        </div>

        <!-- 4. AGENDA & PROGRAM KERJA DINAMIS -->
        <div style="border-top: 1px solid #1e293b; padding-top: 25px;">
            <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h3 style="color: #f8fafc; margin: 0 0 4px 0; font-size: 1.15rem;">Agenda & Program Kerja Utama</h3>
                    <p style="color: #94a3b8; font-size: 0.85rem; margin: 0;">Menampilkan data dinamis dari database MySQL via Eloquent ORM</p>
                </div>

                <form action="{{ url('/pengurus') }}" method="GET" style="display: flex; gap: 8px;">
                    <input type="text" name="search" placeholder="Cari judul / deskripsi..." value="{{ request('search') }}" style="background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 7px 14px; border-radius: 8px; font-size: 0.85rem; outline: none;">
                    <button type="submit" style="background: #06b6d4; color: #0b0f19; border: none; padding: 7px 16px; border-radius: 8px; font-weight: bold; font-size: 0.85rem; cursor: pointer;">Cari</button>
                </form>
            </div>

            <!-- Tombol Filter Status -->
            <div class="no-print" style="display: flex; gap: 8px; margin-bottom: 22px; flex-wrap: wrap; align-items: center;">
                <span style="color: #94a3b8; font-size: 0.82rem; margin-right: 4px;">Filter:</span>
                <a href="{{ url('/pengurus') }}" style="text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; {{ $activeFilter === 'Semua' ? 'background: #06b6d4; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;' }}">
                    Semua ({{ $stats['total'] }})
                </a>
                <a href="{{ url('/pengurus?status=Sedang+Berjalan') }}" style="text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; {{ $activeFilter === 'Sedang Berjalan' ? 'background: #06b6d4; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;' }}">
                    Sedang Berjalan ({{ $stats['running'] }})
                </a>
                <a href="{{ url('/pengurus?status=Perencanaan') }}" style="text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; {{ $activeFilter === 'Perencanaan' ? 'background: #f59e0b; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;' }}">
                    Perencanaan ({{ $stats['planned'] }})
                </a>
                <a href="{{ url('/pengurus?status=Terlaksana') }}" style="text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; {{ $activeFilter === 'Terlaksana' ? 'background: #10b981; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;' }}">
                    Terlaksana ({{ $stats['done'] }})
                </a>
            </div>

            <!-- DETAIL 1 PROGRAM KERJA -->
            @if ($selectedProgram)
                @php
                    $detailStatus = $selectedProgram->status ?? 'Perencanaan';
                    $badgeColor = '#64748b';
                    if ($detailStatus === 'Sedang Berjalan') $badgeColor = '#06b6d4';
                    elseif ($detailStatus === 'Terlaksana') $badgeColor = '#10b981';
                    elseif ($detailStatus === 'Perencanaan') $badgeColor = '#f59e0b';
                @endphp
                <div id="detail-proker" style="background: #1e293b; border: 2px solid #06b6d4; border-radius: 14px; padding: 25px; margin-bottom: 30px; box-shadow: 0 0 30px rgba(6,182,212,0.4);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                        <div>
                            <span style="background: #06b6d4; color: #0b0f19; font-weight: bold; font-size: 0.72rem; padding: 3px 10px; border-radius: 6px; margin-right: 6px;">
                                🔍 DETAIL PROGRAM KERJA
                            </span>
                            <span style="background-color: {{ $badgeColor }}; color: #ffffff; font-size: 0.72rem; font-weight: bold; padding: 3px 10px; border-radius: 20px; text-transform: uppercase;">
                                {{ $detailStatus }}
                            </span>
                        </div>
                        <a href="{{ url('/pengurus') }}" style="color: #38bdf8; text-decoration: none; font-size: 0.85rem; font-weight: 600;">← Kembali ke Semua Proker</a>
                    </div>
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">{{ $selectedProgram->icon ?? '🎮' }}</div>
                    <h3 style="color: #38bdf8; margin: 0 0 8px 0; font-size: 1.35rem;">{{ $selectedProgram->judul }}</h3>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin: 0 0 15px 0;">
                        {{ $selectedProgram->deskripsi }}
                    </p>
                    @if ($selectedProgram->tanggal)
                        <div style="color: #94a3b8; font-size: 0.85rem;">
                            <span>📅 Target/Jadwal: <strong style="color: #f8fafc;">{{ $selectedProgram->tanggal }}</strong></span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- GRID PROGRAM KERJA -->
            @if ($programList->isEmpty())
                <div style="text-align: center; padding: 40px; background: #1e293b; border-radius: 12px; color: #94a3b8;">
                    <p style="margin: 0; font-size: 1rem;">Tidak ada program kerja yang sesuai dengan filter/pencarian.</p>
                    <a href="{{ url('/pengurus') }}" style="display: inline-block; margin-top: 10px; color: #06b6d4; text-decoration: none; font-size: 0.9rem; font-weight: 600;">Reset Filter</a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
                    @foreach ($programList as $prog)
                        @php
                            $statusText = $prog->status ?? 'Perencanaan';
                            $badgeColor = '#64748b';
                            if ($statusText === 'Sedang Berjalan' || $statusText === 'Berjalan') $badgeColor = '#06b6d4';
                            elseif ($statusText === 'Terlaksana' || $statusText === 'Selesai') $badgeColor = '#10b981';
                            elseif ($statusText === 'Perencanaan') $badgeColor = '#f59e0b';
                        @endphp
                        <div class="neon-card" style="background: #1e293b; padding: 22px; border-radius: 14px; text-align: center; border: 1px solid #334155; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <span style="background-color: {{ $badgeColor }}; color: #ffffff; font-size: 0.7rem; font-weight: bold; padding: 3px 10px; border-radius: 20px; text-transform: uppercase;">
                                    {{ $statusText }}
                                </span>
                                <div style="font-size: 2.2rem; margin: 12px 0 8px 0;">{{ $prog->icon ?? '🎮' }}</div>
                                <h4 style="color: #38bdf8; margin: 0 0 8px 0; font-size: 1.05rem;">{{ $prog->judul }}</h4>
                                <p style="color: #cbd5e1; font-size: 0.85rem; margin: 0 0 12px 0; line-height: 1.5;">{{ $prog->deskripsi }}</p>
                            </div>

                            <div style="border-top: 1px solid #334155; padding-top: 12px; margin-top: 10px;">
                                @if ($prog->tanggal)
                                    <p style="color: #94a3b8; font-size: 0.8rem; margin: 0 0 10px 0;">📅 {{ $prog->tanggal }}</p>
                                @endif

                                <a href="{{ url('/pengurus?id=' . $prog->id) }}#detail-proker" style="display: inline-block; width: 100%; box-sizing: border-box; text-decoration: none; background: #0f172a; border: 1px solid #06b6d4; color: #06b6d4; padding: 7px 0; border-radius: 6px; font-size: 0.82rem; font-weight: 600;">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>

</body>
</html>
