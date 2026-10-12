<?php
// =================================================================
// TASK 1: CREATE PHP PAGE (Variable PHP)
// =================================================================
$pageTitle   = "UKM Esport - Program Kerja Prioritas";
$namaUKM     = "CYBER ESPORT UKM";
$tahunAjaran = "2026";


// =================================================================
// TASK 2: PROCESS DATA WITH PHP
// Array Multidimensi Data Program Kerja
// =================================================================
$programList = [
    [
        "id"           => 1,
        "judul"        => "Campus Esports Championship 2026",
        "deskripsi"    => "Turnamen terbesar antar fakultas melingkupi cabang game Valorant, Mobile Legends, dan PUBG Mobile.",
        "kategori"     => "Turnamen",
        "tanggal"      => "15 Oktober 2026",
        "status"       => "Sedang Berjalan",
        "is_prioritas" => true
    ],
    [
        "id"           => 2,
        "judul"        => "Esports Coaching Clinic & Bootcamp",
        "deskripsi"    => "Sesi pelatihan strategi game dan mental bertanding bersama mantan pro-player nasional.",
        "kategori"     => "Pelatihan",
        "tanggal"      => "05 November 2026",
        "status"       => "Perencanaan",
        "is_prioritas" => false
    ],
    [
        "id"           => 3,
        "judul"        => "Internal Scrim & Talent Scouting",
        "deskripsi"    => "Seleksi terbuka untuk penyaringan player berbakat yang akan masuk dalam Roster Utama UKM.",
        "kategori"     => "Seleksi",
        "tanggal"      => "20 September 2026",
        "status"       => "Terlaksana",
        "is_prioritas" => true
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Task 1: Penggunaan Variabel PHP -->
    <title><?= htmlspecialchars($pageTitle); ?></title>
    <!-- Hubungkan ke file CSS yang sudah ada -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- HEADER / NAVIGASI UTAMA -->
    <header class="header">
        <div class="container navbar">
            <div class="logo">
                <span class="logo-icon">🎮</span> <?= htmlspecialchars($namaUKM); ?>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="test.html">Beranda (HTML)</a></li>
                    <li><a href="program.php" style="color: var(--accent-cyan);">Program Kerja (PHP SSR)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container" style="padding: 50px 0;">
        
        <div class="section-heading">
            <!-- Task 1: Penggunaan Variabel PHP -->
            <span class="tag"><?= htmlspecialchars($namaUKM); ?> • <?= htmlspecialchars($tahunAjaran); ?></span>
            <h2>Program Kerja Prioritas (SSR PHP)</h2>
            <p>Halaman ini dirender menggunakan Server-Side Rendering (SSR) oleh PHP.</p>
        </div>

        <!-- =================================================================
             TASK 3: BUILD DYNAMIC SERVER SIDE CONTENT (SSR GRID CARDS)
             ================================================================= -->
        <div class="card-grid">
            <?php 
            // Task 2: Loop Penomoran
            $no = 1; 

            foreach ($programList as $item): 

                // Task 2: Conditional Status / Badge Class
                $statusClass = "status-planned";
                if ($item['status'] === "Sedang Berjalan") {
                    $statusClass = "status-running";
                } elseif ($item['status'] === "Terlaksana") {
                    $statusClass = "status-done";
                }
            ?>
                <article class="card">
                    <div class="card-body">
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <!-- Task 2: Penomoran Loop -->
                            <span style="font-weight: bold; color: var(--accent-cyan); font-size: 14px;">
                                No. <?= $no++; ?>
                            </span>

                            <!-- Task 2: Conditional Status Badge -->
                            <span class="status <?= $statusClass; ?>">
                                <?= htmlspecialchars($item['status']); ?>
                            </span>
                        </div>

                        <h3><?= htmlspecialchars($item['judul']); ?></h3>
                        <p><?= htmlspecialchars($item['deskripsi']); ?></p>

                        <div style="margin-top: auto; padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                            <span class="tag" style="font-size: 11px; padding: 2px 10px;">
                                <?= htmlspecialchars($item['kategori']); ?>
                            </span>
                            <span class="date">📅 <?= htmlspecialchars($item['tanggal']); ?></span>
                        </div>

                    </div>
                </article>

            <?php endforeach; ?>
        </div>

    </main>

    <footer class="footer">
        <div class="container footer-copy">
            <p>&copy; <?= htmlspecialchars($tahunAjaran); ?> <?= htmlspecialchars($namaUKM); ?>. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>