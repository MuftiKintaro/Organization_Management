<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * READ: Menampilkan semua data program (Web Landing Page & RESTful API)
     */
    public function index(Request $request)
    {
        $programList = Program::latest()->get();

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => 'Daftar program kerja berhasil diambil.',
                'data'    => $programList,
            ], 200);
        }

        return view('index', compact('programList'));
    }

    /**
     * DASHBOARD: Menampilkan halaman dashboard admin/ketua umum
     */
    public function dashboard()
    {
        $programList = Program::latest()->get();
        return view('dashboard', compact('programList'));
    }

    /**
     * PENGURUS: Menampilkan halaman profil pengurus & filter proker
     */
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

    /**
     * FORM CREATE: Menampilkan halaman form tambah program kerja (Web)
     */
    public function create()
    {
        return view('programs.create');
    }

    /**
     * CREATE (STORE): Validasi & simpan program kerja baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:100',
            'icon'      => 'nullable|string|max:20',
            'deskripsi' => 'required|string',
            'status'    => 'nullable|string|max:50',
            'tanggal'   => 'nullable|string|max:100',
        ], [
            'judul.required'     => 'Judul program kerja wajib diisi.',
            'judul.max'          => 'Judul program kerja maksimal 100 karakter.',
            'deskripsi.required' => 'Deskripsi program kerja wajib diisi.',
        ]);

        $program = Program::create([
            'judul'     => $validated['judul'],
            'icon'      => $validated['icon'] ?? '🎮',
            'deskripsi' => $validated['deskripsi'],
            'status'    => $validated['status'] ?? 'Perencanaan',
            'tanggal'   => $validated['tanggal'] ?? null,
        ]);

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => 'Program kerja berhasil dibuat.',
                'data'    => $program,
            ], 201);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Program kerja berhasil ditambahkan!');
    }

    /**
     * READ DETAIL: Menampilkan detail 1 program berdasarkan ID (API / Web)
     */
    public function show(Request $request, $id)
    {
        $program = Program::find($id);

        if (!$program) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Program kerja tidak ditemukan.',
                ], 404);
            }
            abort(404);
        }

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => 'Detail program kerja berhasil diambil.',
                'data'    => $program,
            ], 200);
        }

        return view('programs.edit', compact('program'));
    }

    /**
     * FORM EDIT: Menampilkan halaman form edit program kerja (Web)
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('programs.edit', compact('program'));
    }

    /**
     * UPDATE: Validasi & perbarui data program kerja berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        $program = Program::find($id);

        if (!$program) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Program kerja tidak ditemukan.',
                ], 404);
            }
            abort(404);
        }

        $validated = $request->validate([
            'judul'     => 'required|string|max:100',
            'icon'      => 'nullable|string|max:20',
            'deskripsi' => 'required|string',
            'status'    => 'nullable|string|max:50',
            'tanggal'   => 'nullable|string|max:100',
        ], [
            'judul.required'     => 'Judul program kerja wajib diisi.',
            'judul.max'          => 'Judul program kerja maksimal 100 karakter.',
            'deskripsi.required' => 'Deskripsi program kerja wajib diisi.',
        ]);

        $program->update([
            'judul'     => $validated['judul'],
            'icon'      => $validated['icon'] ?? $program->icon ?? '🎮',
            'deskripsi' => $validated['deskripsi'],
            'status'    => $validated['status'] ?? $program->status,
            'tanggal'   => $validated['tanggal'] ?? $program->tanggal,
        ]);

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => 'Program kerja berhasil diperbarui.',
                'data'    => $program,
            ], 200);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Program kerja berhasil diperbarui!');
    }

    /**
     * DELETE (DESTROY): Menghapus data program kerja berdasarkan ID
     */
    public function destroy(Request $request, $id)
    {
        $program = Program::find($id);

        if (!$program) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Program kerja tidak ditemukan.',
                ], 404);
            }
            abort(404);
        }

        $program->delete();

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => 'Program kerja berhasil dihapus.',
            ], 200);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Program kerja berhasil dihapus!');
    }
}
