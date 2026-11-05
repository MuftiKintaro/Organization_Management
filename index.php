<?php
/**
 * MAIN ROUTER & FRONT CONTROLLER: index.php
 * Pola Arsitektur MVC (Model - View - Controller) - UKM Esports Hub
 * 
 * Sistem Navigasi Terpadu:
 * - index.php (Default)             => Menampilkan Landing Page UKM Esports (PHP)
 * - index.php?page=pengurus        => Menjalankan PengurusController (Tugas MVC Pertemuan 7)
 * - index.php?page=dashboard       => Menampilkan Dashboard Manajemen Organisasi (PHP)
 * 
 * Controller Methods:
 * - action=index    => index() (Daftar semua proker, statistik & profil BPH)
 * - action=show&id= => show($id) (Detail 1 proker)
 * - action=process  => process() (Filter status & pencarian)
 * - action=store    => store() (Simpan proker baru via POST)
 * - action=export   => export() (Unduh data JSON proker)
 */

require_once __DIR__ . '/controller/PengurusController.php';

// Menentukan halaman yang diakses
$page = $_GET['page'] ?? 'landing';

// Jika terdapat parameter action, otomatis arahkan ke PengurusController (MVC)
if (isset($_GET['action'])) {
    $page = 'pengurus';
}

switch ($page) {
    case 'pengurus':
        $controller = new PengurusController();
        $action = $_GET['action'] ?? 'index';

        if ($action === 'show') {
            $controller->show($_GET['id'] ?? null);
        } elseif ($action === 'process') {
            $controller->process();
        } elseif ($action === 'store') {
            $controller->store();
        } elseif ($action === 'export') {
            $controller->export();
        } else {
            $controller->index();
        }
        break;

    case 'dashboard':
        require_once __DIR__ . '/view/dashboard.php';
        break;

    case 'landing':
    default:
        require_once __DIR__ . '/view/landing.php';
        break;
}
