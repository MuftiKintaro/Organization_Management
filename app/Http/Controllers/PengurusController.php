<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        // 1. Data Profil Pengurus UKM Esports
        $profileData = [
            'nama'    => 'Budi Santoso',
            'periode' => '2026 - 2027',
            'profil'  => 'Ketua Umum UKM Esports periode 2026/2027 yang berfokus pada pembinaan talenta mahasiswa di bidang esports nasional.',
            'avatar'  => asset('asset/fotobudi.jpeg')
        ];

        // 2. Membaca program.json dari folder public/data/
        $jsonPath = public_path('data/program.json');
        $programList = [];

        if (file_exists($jsonPath)) {
            $jsonData = file_get_contents($jsonPath);
            $programList = json_decode($jsonData, true) ?? [];
        }

        // 3. Merender View Blade
        return view('pengurus', compact('profileData', 'programList'));
    }
}
