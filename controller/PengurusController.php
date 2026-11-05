<?php
/**
 * CONTROLLER: PengurusController.php
 * Tugas Pertemuan 7 - Web Programming: Task 01, Task 02, & Task 03
 * Alur: USER -> REQUEST -> CONTROLLER -> PROCESS -> VIEW
 * 
 * Tanggung Jawab:
 * - Menangani request dari user / browser
 * - Memanggil Model untuk mendapatkan data
 * - Memproses logika bisnis / filter data
 * - Mengirimkan data yang siap pakai ke View
 */

require_once __DIR__ . '/../model/PengurusModel.php';

class PengurusController {
    // Properti instance model
    private $model;

    public function __construct() {
        // Inisialisasi Model Pengurus
        $this->model = new PengurusModel();
    }

    /**
     * Method 1: index() - Task 02
     * Menangani request default halaman utama:
     * - Mengambil data profil pengurus
     * - Mengambil semua program kerja
     * - Mengirim data ke View
     */
    public function index() {
        // 1. Memanggil Model
        $profileData = $this->model->getProfile();
        $programList = $this->model->getPrograms();
        $selectedProgram = null;
        $activeFilter = 'Semua';

        // 2. Mengirim data ke View
        $this->renderView($profileData, $programList, $selectedProgram, $activeFilter);
    }

    /**
     * Method 2: show($id) - Task 02
     * Menangani request detail 1 program kerja tertentu
     * @param int|string|null $id
     */
    public function show($id = null) {
        $profileData = $this->model->getProfile();
        $programList = $this->model->getPrograms();
        $selectedProgram = null;

        if ($id !== null) {
            $selectedProgram = $this->model->getProgramById($id);
        }

        $activeFilter = 'Detail';

        // Mengirim data ke View
        $this->renderView($profileData, $programList, $selectedProgram, $activeFilter);
    }

    /**
     * Method 3: process() - Task 02
     * Memproses request filter status atau pencarian program kerja
     */
    public function process() {
        $status = $_GET['status'] ?? null;
        $keyword = $_GET['search'] ?? null;

        $profileData = $this->model->getProfile();
        $programList = $this->model->filterPrograms($status, $keyword);
        $selectedProgram = null;
        
        $activeFilter = $status ?: ($keyword ? "Cari: \"$keyword\"" : 'Semua');

        // Mengirim data hasil pemrosesan ke View
        $this->renderView($profileData, $programList, $selectedProgram, $activeFilter);
    }

    /**
     * Helper render untuk meneruskan data ke View
     */
    private function renderView($profileData, $programList, $selectedProgram, $activeFilter) {
        $viewPath = __DIR__ . '/../view/Pengurus-View.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "Error: File View tidak ditemukan di {$viewPath}";
        }
    }
}
