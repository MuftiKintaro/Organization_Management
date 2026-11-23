<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programList = Program::all();
        return view('index', compact('programList'));
    }

    public function dashboard()
    {
        $programList = Program::all();
        return view('dashboard', compact('programList'));
    }

    public function pengurus(Request $request)
    {
        $allPrograms = Program::all();

        // Hitung statistik proker dari database
        $total   =$allPrograms->count();
        $running =$allPrograms->whereIn('status', ['Sedang Berjalan', 'Berjalan'])->count();
        $done    =$allPrograms->whereIn('status', ['Terlaksana', 'Selesai'])->count();
        $planned =$total - $running -$done;

        $stats = [
            'total'      => $total,
            'running'    => $running,
            'planned'    => $planned,
            'done'       => $done,
            'percentage' => $total > 0 ? round(($done / $total) * 100) : 0,
        ];

        // Filter & pencarian via Eloquent
        $query = Program::query();

        if ($request->filled('status') && strtolower($request->status) !== 'semua') {
            $query->where('status',$request->status);
        }

        if ($request->filled('search')) {
            $keyword =$request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "\%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        $programList     = $query->get();$selectedProgram = $request->filled('id') ? Program::find($request->id) : null;
        $activeFilter    =$request->status ?? ($request->filled('search') ? 'Cari: "' . $request->search . '"' : 'Semua');

        $profileData = [
            'nama'    => 'Budi Anantha',
            'periode' => '2026 - 2027',
            'profil'  => 'Ketua Umum UKM Esports periode 2026/2027 yang berfokus pada pembinaan talenta mahasiswa di bidang esports nasional.',
            'avatar'  => asset('asset/fotobudi.jpeg'),
        ];

        $bphList = [
            [
                'jabatan' => 'Ketua Umum',
                'nama'    => 'Budi Anantha',
                'nim'     => '230101001',
                'avatar'  => asset('asset/fotobudi.jpeg'),
                'badge'   => '👑 Pimpinan',
            ],
            [
                'jabatan' => 'Wakil Ketua Umum',
                'nama'    => 'Reynaldi Pratama',
                'nim'     => '230101002',
                'avatar'  => 'https://www.shutterstock.com/image-vector/cartoon-illustration-muslim-people-happy-260nw-2674779287.jpg',
                'badge'   => '⚔️ Operasional',
            ],
            [
                'jabatan' => 'Sekretaris Umum',
                'nama'    => 'Siti Rahma',
                'nim'     => '230101015',
                'avatar'  => 'https://www.shutterstock.com/image-vector/cartoon-illustration-muslim-people-happy-260nw-2674779287.jpg',
                'badge'   => '📝 Administrasi',
            ],
            [
                'jabatan' => 'Bendahara Umum',
                'nama'    => 'Nabila Putri',
                'nim'     => '230101020',
                'avatar'  => 'https://www.shutterstock.com/image-vector/cartoon-illustration-muslim-people-happy-260nw-2674779287.jpg',
                'badge'   => '💰 Keuangan',
            ],
        ];

        return view('pengurus', compact(
            'profileData',
            'bphList',
            'programList',
            'stats',
            'selectedProgram',
            'activeFilter'
        ));
    }
}
