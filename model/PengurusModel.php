<?php
/**
 * MODEL: PengurusModel.php
 * Tugas Pertemuan 7 - Web Programming: Task 01, Task 02, & Task 03
 * 
 * Tanggung Jawab:
 * - Mengelola data profil Ketua Umum (name, period, profil, avatar)
 * - Mengelola data jajaran Badan Pengurus Harian (BPH)
 * - Mengelola data program kerja UKM Esports (CRUD: Read & Create)
 * - Menghitung logika statistik proker (Business Logic)
 */

class PengurusModel {
    // Properti Model sesuai Task 03: name, period, programs
    public $name;
    public $period;
    public $programs = [];
    public $profil;
    public $avatar;

    public function __construct() {
        // Inisialisasi data profil Ketua Umum
        $this->name    = 'Budi Anantha';
        $this->period  = '2026 - 2027';
        $this->profil  = 'Ketua Umum UKM Esports periode 2026/2027 yang berfokus pada pembinaan talenta mahasiswa di bidang esports nasional.';
        $this->avatar  = 'asset/fotobudi.jpeg';

        // Memuat daftar program kerja dari file data/program.json
        $this->programs = $this->loadPrograms();
    }

    /**
     * Memuat program kerja dari JSON (dengan fallback array)
     */
    public function loadPrograms() {
        $jsonPath = __DIR__ . '/../data/program.json';
        
        if (file_exists($jsonPath)) {
            $jsonData = file_get_contents($jsonPath);
            $data = json_decode($jsonData, true);
            if (!empty($data) && is_array($data)) {
                return $data;
            }
        }

        // Fallback default
        return [
            [
                "id" => 1,
                "judul" => "Campus Esports Championship 2026",
                "icon" => "🏆",
                "deskripsi" => "Turnamen terbesar antar fakultas melingkupi cabang game Valorant, Mobile Legends, dan PUBG Mobile.",
                "kategori" => "Turnamen",
                "status" => "Sedang Berjalan",
                "tanggal" => "15 Oktober 2026"
            ],
            [
                "id" => 2,
                "judul" => "Esports Coaching Clinic & Bootcamp",
                "icon" => "🎓",
                "deskripsi" => "Sesi pelatihan strategi game dan mental bertanding bersama mantan pro-player nasional.",
                "kategori" => "Pelatihan",
                "status" => "Perencanaan",
                "tanggal" => "05 November 2026"
            ],
            [
                "id" => 3,
                "judul" => "Internal Scrim & Talent Scouting",
                "icon" => "🎯",
                "deskripsi" => "Seleksi terbuka untuk penyaringan player berbakat yang akan masuk dalam Roster Utama UKM.",
                "kategori" => "Seleksi",
                "status" => "Terlaksana",
                "tanggal" => "20 September 2026"
            ]
        ];
    }

    /**
     * Mengambil data profil Ketua Umum
     * @return array
     */
    public function getProfile() {
        return [
            'nama'    => $this->name,
            'periode' => $this->period,
            'profil'  => $this->profil,
            'avatar'  => $this->avatar
        ];
    }

    /**
     * Mengambil seluruh jajaran Badan Pengurus Harian (BPH)
     * @return array
     */
    public function getBphList() {
        return [
            [
                'jabatan' => 'Ketua Umum',
                'nama'    => 'Budi Anantha',
                'nim'     => '230101001',
                'avatar'  => 'asset/fotobudi.jpeg',
                'badge'   => '👑 Pimpinan',
                'fokus'   => 'Regulasi & Hubungan Kampus'
            ],
            [
                'jabatan' => 'Wakil Ketua Umum',
                'nama'    => 'Reynaldi Pratama',
                'nim'     => '230101002',
                'avatar'  => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=300&q=80',
                'badge'   => '⚔️ Operasional',
                'fokus'   => 'Roster Atlet & Turnamen'
            ],
            [
                'jabatan' => 'Sekretaris Umum',
                'nama'    => 'Siti Rahma',
                'nim'     => '230101015',
                'avatar'  => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80',
                'badge'   => '📝 Administrasi',
                'fokus'   => 'Notulensi, SK & Surat Keluar'
            ],
            [
                'jabatan' => 'Bendahara Umum',
                'nama'    => 'Nabila Putri',
                'nim'     => '230101020',
                'avatar'  => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                'badge'   => '💰 Keuangan',
                'fokus'   => 'Anggaran Dana & Kas UKM'
            ]
        ];
    }

    /**
     * Mengambil seluruh daftar program kerja
     * @return array
     */
    public function getPrograms() {
        return $this->programs;
    }

    /**
     * Mengambil 1 program kerja berdasarkan ID
     * @param int|string $id
     * @return array|null
     */
    public function getProgramById($id) {
        foreach ($this->programs as $prog) {
            if (isset($prog['id']) && (int)$prog['id'] === (int)$id) {
                return $prog;
            }
        }
        return null;
    }

    /**
     * Memfilter program kerja berdasarkan status atau kata kunci
     * @param string|null $status
     * @param string|null $keyword
     * @return array
     */
    public function filterPrograms($status = null, $keyword = null) {
        $filtered = $this->programs;

        // Filter berdasarkan status
        if (!empty($status) && strtolower($status) !== 'semua') {
            $filtered = array_filter($filtered, function($item) use ($status) {
                return isset($item['status']) && strtolower($item['status']) === strtolower($status);
            });
        }

        // Filter berdasarkan kata kunci judul/deskripsi
        if (!empty($keyword)) {
            $key = strtolower(trim($keyword));
            $filtered = array_filter($filtered, function($item) use ($key) {
                $judulMatch = isset($item['judul']) && strpos(strtolower($item['judul']), $key) !== false;
                $deskripsiMatch = isset($item['deskripsi']) && strpos(strtolower($item['deskripsi']), $key) !== false;
                return $judulMatch || $deskripsiMatch;
            });
        }

        return array_values($filtered);
    }

    /**
     * Menghitung statistik & progres ketercapaian program kerja (Business Logic)
     * @return array
     */
    public function getStatistics() {
        $total = count($this->programs);
        $running = 0;
        $planned = 0;
        $done = 0;

        foreach ($this->programs as $prog) {
            $st = $prog['status'] ?? 'Perencanaan';
            if ($st === 'Sedang Berjalan' || $st === 'Berjalan') {
                $running++;
            } elseif ($st === 'Terlaksana' || $st === 'Selesai') {
                $done++;
            } else {
                $planned++;
            }
        }

        $percentage = $total > 0 ? round(($done / $total) * 100) : 0;

        return [
            'total'      => $total,
            'running'    => $running,
            'planned'    => $planned,
            'done'       => $done,
            'percentage' => $percentage
        ];
    }

    /**
     * Menambahkan program kerja baru ke dalam data/program.json (Create Data)
     * @param array $newProgram
     * @return bool
     */
    public function addProgram($newProgram) {
        $jsonPath = __DIR__ . '/../data/program.json';
        
        // Tentukan ID baru
        $maxId = 0;
        foreach ($this->programs as $prog) {
            if (isset($prog['id']) && $prog['id'] > $maxId) {
                $maxId = (int)$prog['id'];
            }
        }
        $newProgram['id'] = $maxId + 1;

        // Tambahkan ke array lokal
        $this->programs[] = $newProgram;

        // Simpan kembali ke file JSON
        $encoded = json_encode($this->programs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($encoded !== false) {
            return (bool)file_put_contents($jsonPath, $encoded);
        }
        return false;
    }
}
