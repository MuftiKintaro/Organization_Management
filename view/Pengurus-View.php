<?php
/**
 * VIEW: Pengurus-View.php
 * Tugas Pertemuan 7 - Web Programming: Task 01 & Task 03
 * Tanggung Jawab:
 * - Menerima data yang telah diproses oleh Controller ($profileData, $programList, $selectedProgram, $activeFilter)
 * - Menampilkan antarmuka visual (UI) UKM Esports yang responsif dan konsisten
 * - Tidak melakukan query / pemanggilan data langsung (murni presentasi)
 */

// Fallback data jika View dibuka langsung tanpa melewati Controller
if (!isset($profileData)) {
    $profileData = [
        'nama'    => 'Data Belum Dimuat',
        'periode' => 'Silakan akses melalui index.php',
        'profil'  => 'Halaman View ini harus diakses melalui Controller agar data Model dimuat dengan benar.',
        'avatar'  => 'asset/fotobudi.jpeg'
    ];
}

if (!isset($programList)) {
    $programList = [];
}

$activeFilter = $activeFilter ?? 'Semua';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM Esports Hub - Pengurus & Proker (MVC)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #0b0f19; color: #f8fafc; font-family: 'Segoe UI', sans-serif; padding: 40px 20px; margin: 0;">

    <div style="max-width: 850px; margin: 0 auto; background: #131b2e; border: 1px solid #1e293b; border-radius: 16px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        
        <!-- Header Navigasi -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; padding-bottom: 15px; margin-bottom: 30px; flex-wrap: wrap; gap: 10px;">
            <h2 style="color: #06b6d4; margin: 0; font-size: 1.4rem;">🎮 CYBER ESPORT UKM (MVC)</h2>
            <div style="font-size: 0.9rem; color: #94a3b8;">
                <a href="index.php" style="color: #94a3b8; text-decoration: none; margin-right: 15px;">🏠 Landing Page</a>
                <a href="index.php?page=dashboard" style="color: #94a3b8; text-decoration: none; margin-right: 15px;">📊 Dashboard</a>
                <span style="color: #06b6d4; font-weight: bold;">👤 Pengurus & Proker (MVC)</span>
            </div>
        </div>

        <!-- Profil Pengurus (Data dari Model melalui Controller) -->
        <div style="text-align: center; margin-bottom: 35px;">
            <img src="<?php echo htmlspecialchars($profileData['avatar']); ?>" alt="Foto Pengurus" style="width: 130px; height: 130px; border-radius: 50%; border: 3px solid #06b6d4; object-fit: cover; margin-bottom: 15px; box-shadow: 0 0 15px rgba(6,182,212,0.3);">
            <h1 style="margin: 5px 0; color: #f8fafc; font-size: 1.8rem;"><?php echo htmlspecialchars($profileData['nama']); ?></h1>
            <p style="color: #38bdf8; font-weight: 600; font-size: 1rem; margin: 0 0 12px 0;"><?php echo htmlspecialchars($profileData['periode']); ?></p>
            <p style="color: #94a3b8; max-width: 580px; margin: 0 auto; line-height: 1.6; font-size: 0.95rem;">
                <?php echo htmlspecialchars($profileData['profil']); ?>
            </p>
        </div>

        <!-- SECTION: PROGRAM KERJA -->
        <div style="border-top: 1px solid #1e293b; padding-top: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                <h3 style="color: #f8fafc; margin: 0;">Agenda & Program Kerja Utama</h3>

                <!-- Form Pencarian (Memanggil Controller method process()) -->
                <form action="index.php" method="GET" style="display: flex; gap: 8px;">
                    <input type="hidden" name="page" value="pengurus">
                    <input type="hidden" name="action" value="process">
                    <input type="text" name="search" placeholder="Cari proker..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" style="background: #0b0f19; border: 1px solid #334155; color: #f8fafc; padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; outline: none;">
                    <button type="submit" style="background: #06b6d4; color: #0b0f19; border: none; padding: 6px 14px; border-radius: 8px; font-weight: bold; font-size: 0.85rem; cursor: pointer;">Cari</button>
                </form>
            </div>

            <!-- Tombol Filter Status (Memanggil Controller method process()) -->
            <div style="display: flex; gap: 8px; margin-bottom: 25px; flex-wrap: wrap;">
                <a href="index.php?page=pengurus" style="text-decoration: none; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; <?php echo $activeFilter === 'Semua' ? 'background: #06b6d4; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;'; ?>">
                    Semua
                </a>
                <a href="index.php?page=pengurus&action=process&status=Sedang+Berjalan" style="text-decoration: none; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; <?php echo $activeFilter === 'Sedang Berjalan' ? 'background: #06b6d4; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;'; ?>">
                    Sedang Berjalan
                </a>
                <a href="index.php?page=pengurus&action=process&status=Perencanaan" style="text-decoration: none; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; <?php echo $activeFilter === 'Perencanaan' ? 'background: #f59e0b; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;'; ?>">
                    Perencanaan
                </a>
                <a href="index.php?page=pengurus&action=process&status=Terlaksana" style="text-decoration: none; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; <?php echo $activeFilter === 'Terlaksana' ? 'background: #10b981; color: #0b0f19;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;'; ?>">
                    Terlaksana
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
                <div style="background: #1e293b; border: 2px solid #06b6d4; border-radius: 14px; padding: 25px; margin-bottom: 30px; box-shadow: 0 0 20px rgba(6,182,212,0.15);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <span style="background-color: <?php echo $badgeColor; ?>; color: #ffffff; font-size: 0.75rem; font-weight: bold; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
                            <?php echo htmlspecialchars($detailStatus); ?>
                        </span>
                        <a href="index.php?page=pengurus" style="color: #38bdf8; text-decoration: none; font-size: 0.85rem; font-weight: 600;">← Kembali ke Semua Proker</a>
                    </div>
                    <div style="font-size: 2.5rem; margin-bottom: 10px;"><?php echo $selectedProgram['icon'] ?? '🎮'; ?></div>
                    <h3 style="color: #38bdf8; margin: 0 0 8px 0; font-size: 1.3rem;"><?php echo htmlspecialchars($selectedProgram['judul']); ?></h3>
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin: 0 0 15px 0;">
                        <?php echo htmlspecialchars($selectedProgram['deskripsi']); ?>
                    </p>
                    <div style="display: flex; gap: 20px; color: #94a3b8; font-size: 0.85rem;">
                        <span>🏷️ Kategori: <strong style="color: #f8fafc;"><?php echo htmlspecialchars($selectedProgram['kategori'] ?? '-'); ?></strong></span>
                        <?php if (isset($selectedProgram['tanggal'])) : ?>
                            <span>📅 Jadwal: <strong style="color: #f8fafc;"><?php echo htmlspecialchars($selectedProgram['tanggal']); ?></strong></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- GRID PROGRAM KERJA -->
            <?php if (empty($programList)) : ?>
                <div style="text-align: center; padding: 40px; background: #1e293b; border-radius: 12px; color: #94a3b8;">
                    <p style="margin: 0; font-size: 1rem;">Tidak ada program kerja yang sesuai dengan filter.</p>
                    <a href="index.php?page=pengurus" style="display: inline-block; margin-top: 10px; color: #06b6d4; text-decoration: none; font-size: 0.9rem;">Reset Filter</a>
                </div>
            <?php else : ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 15px;">
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
                        <div style="background: #1e293b; padding: 20px; border-radius: 12px; text-align: center; border: 1px solid #334155; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <span style="background-color: <?php echo $badgeColor; ?>; color: #ffffff; font-size: 0.7rem; font-weight: bold; padding: 3px 10px; border-radius: 20px; text-transform: uppercase;">
                                    <?php echo htmlspecialchars($statusText); ?>
                                </span>
                                <div style="font-size: 2rem; margin: 12px 0 8px 0;"><?php echo $prog['icon'] ?? '🎮'; ?></div>
                                <h4 style="color: #38bdf8; margin: 0 0 8px 0; font-size: 1.05rem;"><?php echo htmlspecialchars($prog['judul']); ?></h4>
                                <p style="color: #cbd5e1; font-size: 0.85rem; margin: 0 0 12px 0; line-height: 1.4;"><?php echo htmlspecialchars($prog['deskripsi']); ?></p>
                            </div>
                            
                            <div style="border-top: 1px solid #334155; padding-top: 12px; margin-top: 8px;">
                                <?php if (isset($prog['tanggal'])) : ?>
                                    <p style="color: #94a3b8; font-size: 0.8rem; margin: 0 0 10px 0;">📅 <?php echo htmlspecialchars($prog['tanggal']); ?></p>
                                <?php endif; ?>
                                
                                <!-- Tombol Show Detail (Memanggil Controller method show($id)) -->
                                <?php if (isset($prog['id'])) : ?>
                                    <a href="index.php?page=pengurus&action=show&id=<?php echo urlencode($prog['id']); ?>" style="display: inline-block; width: 100%; box-sizing: border-box; text-decoration: none; background: #0f172a; border: 1px solid #06b6d4; color: #06b6d4; padding: 6px 0; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
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

</body>
</html>
