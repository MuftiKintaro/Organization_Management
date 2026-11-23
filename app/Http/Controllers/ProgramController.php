<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // TASK 01 & TASK 03: READ (Web View & API JSON)
    public function index(Request $request)
    {
        $programList = Program::all();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'data' => $programList
            ], 200);
        }

        return view('index', compact('programList'));
    }

    // TASK 01: FORM CREATE
    public function create()
    {
        return view('programs.create');
    }

    // TASK 01, TASK 02 & TASK 03: CREATE + VALIDATION (Web & API JSON)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'icon'      => 'nullable|string|max:20',
            'status'    => 'nullable|string|max:50',
            'tanggal'   => 'nullable|string|max:100',
        ], [
            'judul.required'     => 'Judul program kerja wajib diisi.',
            'judul.max'          => 'Judul maksimal 100 karakter.',
            'deskripsi.required' => 'Deskripsi program kerja wajib diisi.',
        ]);

        $program = Program::create([
            'judul'     => $validated['judul'],
            'icon'      => $validated['icon'] ?? '🎮',
            'deskripsi' => $validated['deskripsi'],
            'status'    => $validated['status'] ?? 'Perencanaan',
            'tanggal'   => $validated['tanggal'] ?? null,
        ]);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'message' => 'Berhasil',
                'data'    => $program
            ], 201);
        }

        return redirect()->route('dashboard')->with('success', 'Program kerja baru berhasil ditambahkan!');
    }

    // TASK 03: GET DETAIL BY ID (API JSON)
    public function show($id)
    {
        $program = Program::findOrFail($id);

        return response()->json([
            'data' => $program
        ], 200);
    }

    // TASK 01: FORM EDIT
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('programs.edit', compact('program'));
    }

    // TASK 01, TASK 02 & TASK 03: UPDATE + VALIDATION (Web & API JSON)
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'icon'      => 'nullable|string|max:20',
            'status'    => 'nullable|string|max:50',
            'tanggal'   => 'nullable|string|max:100',
        ], [
            'judul.required'     => 'Judul program kerja wajib diisi.',
            'judul.max'          => 'Judul maksimal 100 karakter.',
            'deskripsi.required' => 'Deskripsi program kerja wajib diisi.',
        ]);

        $program = Program::findOrFail($id);

        $program->update([
            'judul'     => $validated['judul'],
            'icon'      => $validated['icon'] ?? $program->icon ?? '🎮',
            'deskripsi' => $validated['deskripsi'],
            'status'    => $validated['status'] ?? $program->status ?? 'Perencanaan',
            'tanggal'   => $validated['tanggal'] ?? $program->tanggal,
        ]);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'message' => 'Program berhasil diperbarui.',
                'data'    => $program
            ], 200);
        }

        return redirect()->route('dashboard')->with('success', 'Program kerja berhasil diperbarui!');
    }

    // TASK 01 & TASK 03: DELETE (Web & API JSON)
    public function destroy(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'message' => 'Program berhasil dihapus.'
            ], 200);
        }

        return redirect()->route('dashboard')->with('success', 'Program kerja berhasil dihapus!');
    }

    // Halaman Dashboard Organisasi
    public function dashboard()
    {
        $programList = Program::all();
        return view('dashboard', compact('programList'));
    }

    // Halaman Pengurus & Statistik
    public function pengurus(Request $request)
    {
        $allPrograms = Program::all();

        $total   = $allPrograms->count();
        $running = $allPrograms->whereIn('status', ['Sedang Berjalan', 'Berjalan'])->count();
        $done    = $allPrograms->whereIn('status', ['Terlaksana', 'Selesai'])->count();
        $planned = $total - $running - $done;

        $stats = [
            'total'      => $total,
            'running'    => $running,
            'planned'    => $planned,
            'done'       => $done,
            'percentage' => $total > 0 ? round(($done / $total) * 100) : 0,
        ];

        $query = Program::query();

        if ($request->filled('status') && strtolower($request->status) !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        $programList     = $query->get();
        $selectedProgram = $request->filled('id') ? Program::find($request->id) : null;
        $activeFilter    = $request->status ?? ($request->filled('search') ? 'Cari: "' . $request->search . '"' : 'Semua');

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
