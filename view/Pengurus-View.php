<?php
/**
 * VIEW: Pengurus-View.php
 * Tugas Pertemuan 7 - Web Programming: Task 01 & Task 03
 * Arsitektur: Model - View - Controller (Tema: Cyber Esports UKM)
 * 
 * Tanggung Jawab:
 * - Menampilkan Profil Ketua & Jajaran Badan Pengurus Harian (BPH)
 * - Menampilkan Bar Metrik Statistik Progres Organisasi
 * - Menampilkan Agenda Program Kerja Interaktif (Search, Filter, Show Detail)
 * - Modal Form Tambah Program Kerja Baru (Create Data)
 */

// Fallback otomatis jika View dibuka langsung tanpa Controller
if (!isset($profileData) || !isset($programList) || empty($programList)) {
    require_once __DIR__ . '/../model/PengurusModel.php';
    $autoModel   = new PengurusModel();
    $profileData = $autoModel->getProfile();
    $bphList     = $autoModel->getBphList();
    $programList = $autoModel->getPrograms();
    $stats       = $autoModel->getStatistics();
}

$bphList      = $bphList ?? [];
$stats        = $stats ?? ['total' => count($programList), 'running' => 0, 'planned' => 0, 'done' => 0, 'percentage' => 0];
$activeFilter = $activeFilter ?? 'Semua';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM Esports Hub - Pengurus & Proker (MVC)</title>
    <link rel="stylesheet" href="style.css">
    
    <style>
        /* Custom Modern Micro-interactions & Neon Glowing */
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
        .modal-popup {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(11, 15, 25, 0.85);
            backdrop-filter: blur(5px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .modal-popup.active {
            display: flex;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; color: #000000 !important; }
            .neon-card { border: 1px solid #cccccc !important; box-shadow: none !important; color: #000 !important; }
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
                    <span style="color: #94a3b8; font-size: 0.8rem; letter-spacing: 0.5px;">MVC ARCHITECTURE (TASK 01 - 03)</span>
                </div>
            </div>

            <!-- Menu Tautan -->
            <div style="font-size: 0.88rem; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                <a href="index.php" style="color: #94a3b8; text-decoration: none; font-weight: 500;">🏠 Landing Page</a>
                <a href="index.php?page=dashboard" style="color: #94a3b8; text-decoration: none; font-weight: 500;">📊 Dashboard</a>
                <a href="index.php?page=pengurus&action=export" style="background: #0f172a; border: 1px solid #334155; color: #38bdf8; text-decoration: none; padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem;">
                    📥 Unduh JSON
                </a>
                <button onclick="window.print()" style="background: #0f172a; border: 1px solid #334155; color: #94a3b8; padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; cursor: pointer;">
                    🖨️ Cetak
                </button>
                <button onclick="document.getElementById('modal-proker').classList.add('active')" style="background: #06b6d4; color: #0b0f19; border: none; padding: 6px 14px; border-radius: 6px; font-weight: bold; font-size: 0.82rem; cursor: pointer; box-shadow: 0 0 12px rgba(6,182,212,0.4);">
                    + Tambah Proker
                </button>
            </div>
        </div>

        <!-- NOTIFIKASI SUKSES (FLASH MESSAGE) -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success_add') : ?>
            <div class="no-print" style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #34d399; padding: 12px 18px; border-radius: 10px; margin-bottom: 25px; font-size: 0.9rem; display: flex; justify-content: space-between; align-items: center;">
                <span>✅ <strong>Berhasil!</strong> Program kerja baru telah disimpan ke file <code>data/program.json</code> melalui Controller!</span>
                <a href="index.php?page=pengurus" style="color: #34d399; text-decoration: none; font-weight: bold; font-size: 1.1rem;">&times;</a>
            </div>
        <?php endif; ?>

        <!-- 1. PROFIL UTAMA KETUA UMUM (DATA DARI MODEL) -->
        <div style="text-align: center; margin-bottom: 35px; background: radial-gradient(circle at top, rgba(6,182,212,0.1) 0%, transparent 70%); padding: 25px 15px; border-radius: 16px;">
            <img src="<?php echo htmlspecialchars($profileData['avatar']); ?>" alt="Foto Budi Anantha" style="width: 125px; height: 125px; border-radius: 50%; border: 3px solid #06b6d4; object-fit: cover; margin-bottom: 12px; box-shadow: 0 0 20px rgba(6,182,212,0.35);">
            <h1 style="margin: 4px 0; color: #f8fafc; font-size: 1.85rem; letter-spacing: -0.5px;"><?php echo htmlspecialchars($profileData['nama']); ?></h1>
            <p style="color: #38bdf8; font-weight: 600; font-size: 1rem; margin: 0 0 10px 0;">👑 Ketua Umum UKM Esports (Periode <?php echo htmlspecialchars($profileData['periode']); ?>)</p>
            <p style="color: #94a3b8; max-width: 580px; margin: 0 auto; line-height: 1.6; font-size: 0.94rem;">
                <?php echo htmlspecialchars($profileData['profil']); ?>
            </p>
        </div>

        <!-- 2. STRUKTUR LENGKAP BADAN PENGURUS HARIAN (BPH) -->
        <div style="margin-bottom: 35px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="color: #f8fafc; margin: 0; font-size: 1.15rem;">👥 Jajaran Badan Pengurus Harian (BPH)</h3>
                <span style="color: #06b6d4; font-size: 0.8rem; font-weight: 600;">Dikelola via PengurusModel</span>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                <?php foreach ($bphList as $bph) : ?>
                    <div class="bph-card">
                        <img src="<?php echo htmlspecialchars($bph['avatar']); ?>" alt="<?php echo htmlspecialchars($bph['nama']); ?>" style="width: 65px; height: 65px; border-radius: 50%; border: 2px solid #06b6d4; object-fit: cover; margin-bottom: 10px;">
                        <span style="display: inline-block; background: #0f172a; border: 1px solid #334155; color: #38bdf8; font-size: 0.7rem; font-weight: bold; padding: 2px 8px; border-radius: 12px; margin-bottom: 6px;">
                            <?php echo htmlspecialchars($bph['badge']); ?>
                        </span>
                        <h4 style="margin: 0 0 4px 0; color: #f8fafc; font-size: 0.95rem;"><?php echo htmlspecialchars($bph['nama']); ?></h4>
                        <p style="margin: 0 0 4px 0; color: #06b6d4; font-size: 0.8rem; font-weight: 600;"><?php echo htmlspecialchars($bph['jabatan']); ?></p>
                        <p style="margin: 0; color: #64748b; font-size: 0.75rem;">NIM: <?php echo htmlspecialchars($bph['nim']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 3. METRIK STATISTIK PROKER (BUSINESS LOGIC DI MODEL) -->
        <div style="border-top: 1px solid #1e293b; padding-top: 25px; margin-bottom: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 8px;">
                <h3 style="color: #f8fafc; margin: 0; font-size: 1.15rem;">📊 Statistik & Ketercapaian Program Kerja</h3>
                <span style="color: #38bdf8; font-size: 0.85rem; font-weight: bold;">Progres Selesai: <?php echo $stats['percentage']; ?>%</span>
            </div>

            <!-- Progress Bar -->
            <div style="width: 100%; height: 8px; background: #1e293b; border-radius: 10px; overflow: hidden; margin-bottom: 16px;">
                <div style="width: <?php echo $stats['percentage']; ?>%; height: 100%; background: linear-gradient(90deg, #06b6d4, #10b981); border-radius: 10px;"></div>
            </div>

            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <div class="stat-pill">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #f8fafc;"><?php echo $stats['total']; ?></div>
                    <div style="font-size: 0.78rem; color: #94a3b8;">Total Proker</div>
                </div>
                <div class="stat-pill" style="border-color: rgba(6,182,212,0.4);">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #06b6d4;"><?php echo $stats['running']; ?></div>
                    <div style="font-size: 0.78rem; color: #06b6d4;">🔵 Sedang Berjalan</div>
                </div>
                <div class="stat-pill" style="border-color: rgba(245,158,11,0.4);">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #f59e0b;"><?php echo $stats['planned']; ?></div>
                    <div style="font-size: 0.78rem; color: #f59e0b;">🟡 Perencanaan</div>
                </div>
                <div class="stat-pill" style="border-color: rgba(16,185,129,0.4);">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #10b981;"><?php echo $stats['done']; ?></div>
                    <div style="font-size: 0.78rem; color: #10b981;">🟢 Terlaksana</div>
                </div>
            </div>
        </div>

        <!-- 4. SECTION: AGENDA & PROGRAM KERJA DINAMIS -->
        <div style="border-top: 1px solid #1e293b; padding-top: 25px;">
            <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h3 style="color: #f8fafc; margin: 0 0 4px 0; font-size: 1.15rem;">Agenda & Program Kerja Utama</h3>
                    <p style="color: #94a3b8; font-size: 0.85rem; margin: 0;">Menampilkan data dinamis dari file JSON via Controller</p>
                </div>

                <!-- Form Pencarian (Memanggil Controller method process()) -->
                <form action="index.php" method="GET" style="display: flex; gap: 8px;">
                    <input type="hidden" name="page" value="pengurus">
                    <input type="hidden" name="action" value="process">
                    <input type="text" name="search" placeholder="Cari judul / deskripsi..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" style="background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 7px 14px; border-radius: 8px; font-size: 0.85rem; outline: none;">
                    <button type="submit" style="background: #06b6d4; color: #0b0f19; border: none; padding: 7px 16px; border-radius: 8px; font-weight: bold; font-size: 0.85rem; cursor: pointer;">Cari</button>
                </form>
            </div>

            <!-- Tombol Filter Status (Memanggil Controller method process()) -->
            <div class="no-print" style="display: flex; gap: 8px; margin-bottom: 22px; flex-wrap: wrap; align-items: center;">
                <span style="color: #94a3b8; font-size: 0.82rem; margin-right: 4px;">Filter:</span>
                <a href="index.php?page=pengurus" style="text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; <?php echo $activeFilter === 'Semua' ? 'background: #06b6d4; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;'; ?>">
                    Semua (<?php echo $stats['total']; ?>)
                </a>
                <a href="index.php?page=pengurus&action=process&status=Sedang+Berjalan" style="text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; <?php echo $activeFilter === 'Sedang Berjalan' ? 'background: #06b6d4; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;'; ?>">
                    Sedang Berjalan (<?php echo $stats['running']; ?>)
                </a>
                <a href="index.php?page=pengurus&action=process&status=Perencanaan" style="text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; <?php echo $activeFilter === 'Perencanaan' ? 'background: #f59e0b; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;'; ?>">
                    Perencanaan (<?php echo $stats['planned']; ?>)
                </a>
                <a href="index.php?page=pengurus&action=process&status=Terlaksana" style="text-decoration: none; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; <?php echo $activeFilter === 'Terlaksana' ? 'background: #10b981; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;'; ?>">
                    Terlaksana (<?php echo $stats['done']; ?>)
                </a>
            </div>

            <!-- JIKA USER KLIK SHOW (DETAIL 1 PROGRAM KERJA) -->
            <?php if (!empty($selectedProgram)) : 
                $detailStatus = $selectedProgram['status'] ?? 'Perencanaan';
                $badgeColor = "#64748b";
                if ($detailStatus === "Sedang Berjalan") $badgeColor = "#06b6d4";
                elseif ($detailStatus === "Terlaksana") $badgeColor = "#10b981";
                elseif ($detailStatus === "Perencanaan") $badgeColor = "#f59e0b";
            ?>
                <div style="background: #1e293b; border: 2px solid #06b6d4; border-radius: 14px; padding: 25px; margin-bottom: 30px; box-shadow: 0 0 25px rgba(6,182,212,0.25);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <span style="background-color: <?php echo $badgeColor; ?>; color: #ffffff; font-size: 0.75rem; font-weight: bold; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
                            <?php echo htmlspecialchars($detailStatus); ?>
                        </span>
                        <a href="index.php?page=pengurus" style="color: #38bdf8; text-decoration: none; font-size: 0.85rem; font-weight: 600;">← Kembali ke Semua Proker</a>
                    </div>
                    <div style="font-size: 2.5rem; margin-bottom: 10px;"><?php echo $selectedProgram['icon'] ?? '🎮'; ?></div>
                    <h3 style="color: #38bdf8; margin: 0 0 8px 0; font-size: 1.35rem;"><?php echo htmlspecialchars($selectedProgram['judul']); ?></h3>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin: 0 0 15px 0;">
                        <?php echo htmlspecialchars($selectedProgram['deskripsi']); ?>
                    </p>
                    <div style="display: flex; gap: 20px; color: #94a3b8; font-size: 0.85rem; flex-wrap: wrap;">
                        <span>🏷️ Kategori: <strong style="color: #f8fafc;"><?php echo htmlspecialchars($selectedProgram['kategori'] ?? '-'); ?></strong></span>
                        <?php if (isset($selectedProgram['tanggal'])) : ?>
                            <span>📅 Target/Jadwal: <strong style="color: #f8fafc;"><?php echo htmlspecialchars($selectedProgram['tanggal']); ?></strong></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- GRID PROGRAM KERJA -->
            <?php if (empty($programList)) : ?>
                <div style="text-align: center; padding: 40px; background: #1e293b; border-radius: 12px; color: #94a3b8;">
                    <p style="margin: 0; font-size: 1rem;">Tidak ada program kerja yang sesuai dengan filter/pencarian.</p>
                    <a href="index.php?page=pengurus" style="display: inline-block; margin-top: 10px; color: #06b6d4; text-decoration: none; font-size: 0.9rem; font-weight: 600;">Reset Filter</a>
                </div>
            <?php else : ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
                    <?php foreach ($programList as $prog) : 
                        $statusText = $prog['status'] ?? ($prog['kategori'] ?? 'Perencanaan');
                        $badgeColor = "#64748b";

                        if ($statusText === "Sedang Berjalan" || $statusText === "Berjalan") {
                            $badgeColor = "#06b6d4";
                        } elseif ($statusText === "Terlaksana" || $statusText === "Selesai") {
                            $badgeColor = "#10b981";
                        } elseif ($statusText === "Perencanaan") {
                            $badgeColor = "#f59e0b";
                        }
                    ?>
                        <div class="neon-card" style="background: #1e293b; padding: 22px; border-radius: 14px; text-align: center; border: 1px solid #334155; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <span style="background-color: <?php echo $badgeColor; ?>; color: #ffffff; font-size: 0.7rem; font-weight: bold; padding: 3px 10px; border-radius: 20px; text-transform: uppercase;">
                                    <?php echo htmlspecialchars($statusText); ?>
                                </span>
                                <div style="font-size: 2.2rem; margin: 12px 0 8px 0;"><?php echo $prog['icon'] ?? '🎮'; ?></div>
                                <h4 style="color: #38bdf8; margin: 0 0 8px 0; font-size: 1.05rem;"><?php echo htmlspecialchars($prog['judul']); ?></h4>
                                <p style="color: #cbd5e1; font-size: 0.85rem; margin: 0 0 12px 0; line-height: 1.5;"><?php echo htmlspecialchars($prog['deskripsi']); ?></p>
                            </div>
                            
                            <div style="border-top: 1px solid #334155; padding-top: 12px; margin-top: 10px;">
                                <?php if (isset($prog['tanggal'])) : ?>
                                    <p style="color: #94a3b8; font-size: 0.8rem; margin: 0 0 10px 0;">📅 <?php echo htmlspecialchars($prog['tanggal']); ?></p>
                                <?php endif; ?>
                                
                                <!-- Tombol Show Detail (Memanggil Controller method show($id)) -->
                                <?php if (isset($prog['id'])) : ?>
                                    <a href="index.php?page=pengurus&action=show&id=<?php echo urlencode($prog['id']); ?>" style="display: inline-block; width: 100%; box-sizing: border-box; text-decoration: none; background: #0f172a; border: 1px solid #06b6d4; color: #06b6d4; padding: 7px 0; border-radius: 6px; font-size: 0.82rem; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#06b6d4'; this.style.color='#0b0f19';" onmouseout="this.style.background='#0f172a'; this.style.color='#06b6d4';">
                                        Lihat Detail
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <!-- MODAL TAMBAH PROKER BARU (CREATE DATA KE JSON) -->
    <div id="modal-proker" class="modal-popup">
        <div style="background: #131b2e; border: 1px solid #06b6d4; border-radius: 16px; padding: 28px; width: 90%; max-width: 480px; box-shadow: 0 20px 40px rgba(0,0,0,0.8); position: relative;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #1e293b; padding-bottom: 12px;">
                <h3 style="color: #f8fafc; margin: 0; font-size: 1.2rem;">🎯 Tambah Program Kerja Baru</h3>
                <button onclick="document.getElementById('modal-proker').classList.remove('active')" style="background: none; border: none; color: #94a3b8; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>

            <form action="index.php?page=pengurus&action=store" method="POST">
                <div style="margin-bottom: 14px;">
                    <label style="display: block; color: #94a3b8; font-size: 0.82rem; margin-bottom: 6px;">Nama Program Kerja</label>
                    <input type="text" name="judul" required placeholder="Contoh: Valorant Campus Cup" style="width: 100%; box-sizing: border-box; background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 8px 12px; border-radius: 8px; font-size: 0.9rem; outline: none;">
                </div>

                <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                    <div style="flex: 1;">
                        <label style="display: block; color: #94a3b8; font-size: 0.82rem; margin-bottom: 6px;">Icon Emoji</label>
                        <select name="icon" style="width: 100%; box-sizing: border-box; background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 8px 12px; border-radius: 8px; font-size: 0.9rem; outline: none;">
                            <option value="🏆">🏆 Turnamen</option>
                            <option value="🎓">🎓 Bootcamp/Pelatihan</option>
                            <option value="🎯">🎯 Scrim/Seleksi</option>
                            <option value="⚙️">⚙️ Infrastruktur</option>
                            <option value="🎙️">🎙️ Caster/Media</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; color: #94a3b8; font-size: 0.82rem; margin-bottom: 6px;">Status Proker</label>
                        <select name="status" style="width: 100%; box-sizing: border-box; background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 8px 12px; border-radius: 8px; font-size: 0.9rem; outline: none;">
                            <option value="Perencanaan">Perencanaan</option>
                            <option value="Sedang Berjalan">Sedang Berjalan</option>
                            <option value="Terlaksana">Terlaksana</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                    <div style="flex: 1;">
                        <label style="display: block; color: #94a3b8; font-size: 0.82rem; margin-bottom: 6px;">Kategori</label>
                        <input type="text" name="kategori" value="Turnamen" placeholder="Contoh: Turnamen, Workshop" style="width: 100%; box-sizing: border-box; background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 8px 12px; border-radius: 8px; font-size: 0.9rem; outline: none;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; color: #94a3b8; font-size: 0.82rem; margin-bottom: 6px;">Target Tanggal</label>
                        <input type="text" name="tanggal" value="<?php echo date('d M Y'); ?>" placeholder="Contoh: 15 Des 2026" style="width: 100%; box-sizing: border-box; background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 8px 12px; border-radius: 8px; font-size: 0.9rem; outline: none;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #94a3b8; font-size: 0.82rem; margin-bottom: 6px;">Deskripsi Singkat</label>
                    <textarea name="deskripsi" required rows="3" placeholder="Jelaskan tujuan dan ruang lingkup program kerja ini..." style="width: 100%; box-sizing: border-box; background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 8px 12px; border-radius: 8px; font-size: 0.9rem; outline: none; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="document.getElementById('modal-proker').classList.remove('active')" style="background: #1e293b; color: #cbd5e1; border: 1px solid #334155; padding: 8px 18px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Batal
                    </button>
                    <button type="submit" style="background: #06b6d4; color: #0b0f19; border: none; padding: 8px 20px; border-radius: 8px; font-weight: bold; cursor: pointer; box-shadow: 0 0 12px rgba(6,182,212,0.4);">
                        Simpan ke JSON
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
