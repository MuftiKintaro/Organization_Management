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
 * Controller Methods (Pertemuan 7 - Task 02):
 * - index.php?page=pengurus&action=index    => index() (Daftar semua proker & profil)
 * - index.php?page=pengurus&action=show&id= => show($id) (Detail 1 proker)
 * - index.php?page=pengurus&action=process  => process() (Filter status & pencarian)
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
