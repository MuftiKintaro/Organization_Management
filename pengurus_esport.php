<?php

// 1. Membuat Class
class PengurusEsports {
    // Property (Data)
    public $nama;
    public $periode;
    public $program = [];
    public $profil;
    public $avatar;

    // Constructor untuk inisialisasi awal saat object dibuat
    public function __construct($nama, $periode, $program, $profil, $avatar) {
        $this->nama = $nama;
        $this->periode = $periode;
        $this->program = $program;
        $this->profil = $profil;
        $this->avatar = $avatar;
    }

    // Method 1: Mengambil data profil pengurus - Task 02
    public function getProfile() {
        return [
            'nama' => $this->nama,
            'periode' => $this->periode,
            'profil' => $this->profil,
            'avatar' => $this->avatar
        ];
    }

    // Method 2: Mengambil daftar program kerja - Task 02
    public function getPrograms() {
        return $this->program;
    }
}

// 2. Instansiasi Object - Task 01
$pengurus = new PengurusEsports(
    "Reynaldi Pratama",
    "2026 - 2027",
    [
        ["judul" => "Pendidikan & Bootcamp", "icon" => "🎓", "deskripsi" => "Coaching Clinic MLBB & Valorant"],
        ["judul" => "Turnamen Utama", "icon" => "🏆", "deskripsi" => "Campus Esports Championship 2026"],
        ["judul" => "Infrastruktur & Platform", "icon" => "⚙️", "deskripsi" => "Pengembangan Web Hub UKM Esports"]
    ],
    "Ketua Umum UKM Esports periode 2026/2027 yang berfokus pada pembinaan talenta mahasiswa di bidang esports nasional.",
    "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSuyEmwztLuQeKncS7Qurzk-9PFs-pZQQsFIu8zIXP6XCqqXJvlwxXPm1Q&s=10"
);

// 3. Memanggil Method Object - Task 02 & Task 03
$dataProfil = $pengurus->getProfile();
$daftarProgram = $pengurus->getPrograms();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM Esports Hub - Dynamic Content</title>
</head>
<body style="background-color: #0b0f19; color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px 20px; margin: 0;">

    <!-- =============================================================
         TASK 03: GENERATE DYNAMIC CONTENT WITH OBJECT
         ============================================================= -->
    <div style="max-width: 800px; margin: 0 auto; background: #131b2e; border: 1px solid #1e293b; border-radius: 16px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        
        <!-- Header Navigasi -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; padding-bottom: 15px; margin-bottom: 30px;">
            <h2 style="color: #06b6d4; margin: 0; font-size: 1.4rem;">🎮 UKM Esports Hub</h2>
            <div style="font-size: 0.9rem; color: #94a3b8;">
                <span style="margin-right: 15px; cursor: pointer;">Beranda</span>
                <span style="margin-right: 15px; cursor: pointer;">Program</span>
                <span style="color: #06b6d4; font-weight: bold; cursor: pointer;">Profil</span>
            </div>
        </div>

        <!-- Profil Pengurus (Data berasal dari $pengurus->getProfile()) -->
        <div style="text-align: center; margin-bottom: 40px;">
            <img src="<?php echo htmlspecialchars($dataProfil['avatar']); ?>" alt="Foto Pengurus" style="width: 130px; height: 130px; border-radius: 50%; border: 3px solid #06b6d4; object-fit: cover; margin-bottom: 15px;">
            <h1 style="margin: 5px 0; color: #f8fafc; font-size: 1.8rem;"><?php echo htmlspecialchars($dataProfil['nama']); ?></h1>
            <p style="color: #38bdf8; font-weight: 600; font-size: 1rem; margin: 0 0 12px 0;"><?php echo htmlspecialchars($dataProfil['periode']); ?></p>
            <p style="color: #94a3b8; max-width: 550px; margin: 0 auto; line-height: 1.6; font-size: 0.95rem;">
                <?php echo htmlspecialchars($dataProfil['profil']); ?>
            </p>
        </div>

        <!-- Program Utama (Data berasal dari $pengurus->getPrograms()) -->
        <div style="border-top: 1px solid #1e293b; padding-top: 25px;">
            <h3 style="color: #f8fafc; text-align: center; margin-bottom: 20px;">Program Utama</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <?php foreach ($daftarProgram as $prog) : ?>
                    <div style="background: #1e293b; padding: 20px; border-radius: 12px; text-align: center; border: 1px solid #334155;">
                        <div style="font-size: 2rem; margin-bottom: 8px;"><?php echo $prog['icon']; ?></div>
                        <h4 style="color: #38bdf8; margin: 0 0 6px 0;"><?php echo htmlspecialchars($prog['judul']); ?></h4>
                        <p style="color: #cbd5e1; font-size: 0.85rem; margin: 0; line-height: 1.4;"><?php echo htmlspecialchars($prog['deskripsi']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

</body>
</html>