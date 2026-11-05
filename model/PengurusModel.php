<?php
/**
 * MODEL: PengurusModel.php
 * Tugas Pertemuan 7 - Web Programming: Task 01 & Task 03
 * Tanggung Jawab:
 * - Mengelola data profil pengurus (name, period, profil, avatar)
 * - Mengelola data program kerja UKM Esports (programs)
 * - Menyediakan method untuk query, filter, dan pengambilan data spesifik
 */

class PengurusModel {
    // Properti Model sesuai Task 03: name, period, programs
    public $name;
    public $period;
    public $programs = [];
    public $profil;
    public $avatar;

    public function __construct() {
        // Inisialisasi data profil pengurus UKM Esports
        $this->name    = 'Budi Anantha';
        $this->period  = '2026 - 2027';
        $this->profil  = 'Ketua Umum UKM Esports periode 2026/2027 yang berfokus pada pembinaan talenta mahasiswa di bidang esports nasional.';
        $this->avatar  = 'asset/fotobudi.jpeg';

        // Memuat daftar program kerja dari file data/program.json
        $this->programs = $this->loadPrograms();
    }

    /**
     * Memuat program kerja dari JSON (dengan fallback array jika file tidak ada)
     */
    private function loadPrograms() {
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
     * Mengambil data profil pengurus
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
     * Mengambil seluruh daftar program kerja
     * @return array
     */
    public function getPrograms() {
        return $this->programs;
    }

    /**
     * Mengambil 1 program kerja berdasarkan ID
     * (Digunakan pada Controller method show())
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
     * Memfilter program kerja berdasarkan status atau kata kunci pencarian
     * (Digunakan pada Controller method process())
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
}
