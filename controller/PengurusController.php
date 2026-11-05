<?php
/**
 * CONTROLLER: PengurusController.php
 * Tugas Pertemuan 7 - Web Programming: Task 01, Task 02, & Task 03
 * Alur: USER -> REQUEST -> CONTROLLER -> PROCESS -> VIEW
 * 
 * Tanggung Jawab:
 * - Menangani request browser (index, show, process, store, export)
 * - Memanggil Model untuk query data & statistik
 * - Memproses penyimpanan data baru ke file JSON
 * - Mengirimkan data yang siap pakai ke View
 */

require_once __DIR__ . '/../model/PengurusModel.php';

class PengurusController {
    private $model;

    public function __construct() {
        // Inisialisasi Model Pengurus
        $this->model = new PengurusModel();
    }

    /**
     * Method 1: index() - Task 02
     * Menampilkan profil, jajaran BPH, statistik, dan semua agenda proker
     */
    public function index() {
        $profileData     = $this->model->getProfile();
        $bphList         = $this->model->getBphList();
        $programList     = $this->model->getPrograms();
        $stats           = $this->model->getStatistics();
        $selectedProgram = null;
        $activeFilter    = 'Semua';

        $this->renderView($profileData, $bphList, $programList, $stats, $selectedProgram, $activeFilter);
    }

    /**
     * Method 2: show($id) - Task 02
     * Menampilkan rincian detail 1 program kerja berdasarkan ID
     * @param int|string|null $id
     */
    public function show($id = null) {
        $profileData     = $this->model->getProfile();
        $bphList         = $this->model->getBphList();
        $programList     = $this->model->getPrograms();
        $stats           = $this->model->getStatistics();
        $selectedProgram = null;

        if ($id !== null) {
            $selectedProgram = $this->model->getProgramById($id);
        }

        $activeFilter = 'Detail';

        $this->renderView($profileData, $bphList, $programList, $stats, $selectedProgram, $activeFilter);
    }

    /**
     * Method 3: process() - Task 02
     * Memproses request filter status atau pencarian proker
     */
    public function process() {
        $status  = $_GET['status'] ?? null;
        $keyword = $_GET['search'] ?? null;

        $profileData     = $this->model->getProfile();
        $bphList         = $this->model->getBphList();
        $programList     = $this->model->filterPrograms($status, $keyword);
        $stats           = $this->model->getStatistics();
        $selectedProgram = null;
        
        $activeFilter = $status ?: ($keyword ? "Cari: \"$keyword\"" : 'Semua');

        $this->renderView($profileData, $bphList, $programList, $stats, $selectedProgram, $activeFilter);
    }

    /**
     * Method 4: store() - Peningkatan CRUD (Create Data)
     * Menangani form penambahan program kerja baru
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $judul     = trim($_POST['judul'] ?? '');
            $deskripsi = trim($_POST['deskripsi'] ?? '');
            $kategori  = trim($_POST['kategori'] ?? 'Umum');
            $status    = trim($_POST['status'] ?? 'Perencanaan');
            $tanggal   = trim($_POST['tanggal'] ?? date('d M Y'));
            $icon      = trim($_POST['icon'] ?? '🎮');

            if (!empty($judul) && !empty($deskripsi)) {
                $newProgram = [
                    'judul'     => $judul,
                    'icon'      => $icon,
                    'deskripsi' => $deskripsi,
                    'kategori'  => $kategori,
                    'tanggal'   => $tanggal,
                    'status'    => $status
                ];

                $this->model->addProgram($newProgram);
                header("Location: index.php?page=pengurus&msg=success_add");
                exit;
            }
        }

        // Jika validasi gagal, kembali ke halaman utama
        header("Location: index.php?page=pengurus&msg=error_empty");
        exit;
    }

    /**
     * Method 5: export() - Peningkatan Ekspor Data JSON
     * Mengunduh file data program kerja dalam bentuk .json
     */
    public function export() {
        $data = $this->model->getPrograms();
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="proker-esports-' . date('Ymd') . '.json"');
        echo $jsonData;
        exit;
    }

    /**
     * Helper render untuk meneruskan data ke View
     */
    private function renderView($profileData, $bphList, $programList, $stats, $selectedProgram, $activeFilter) {
        $viewPath = __DIR__ . '/../view/Pengurus-View.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "Error: File View tidak ditemukan di {$viewPath}";
        }
    }
}
