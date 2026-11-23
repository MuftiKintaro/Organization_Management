<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program Kerja - Cyber Esport UKM</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body style="background-color: #0b0f19; color: #f8fafc; padding: 40px 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #131b2e; border: 1px solid #1e293b; border-radius: 16px; padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="margin: 0; color: #06b6d4;">✏️ Edit Program Kerja</h2>
            <a href="{{ route('dashboard') }}" class="button button-outline btn-sm">← Kembali</a>
        </div>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #f87171; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px;">
                <ul style="margin: 0 0 0 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('programs.update', $program->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="judul">Judul Program Kerja *</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $program->judul) }}">
            </div>

            <div class="form-group">
                <label for="icon">Icon (Emoji)</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon', $program->icon) }}">
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $program->deskripsi) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="Perencanaan" {{ old('status', $program->status) == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                    <option value="Sedang Berjalan" {{ old('status', $program->status) == 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                    <option value="Terlaksana" {{ old('status', $program->status) == 'Terlaksana' ? 'selected' : '' }}>Terlaksana</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal">Target Tanggal</label>
                <input type="text" id="tanggal" name="tanggal" value="{{ old('tanggal', $program->tanggal) }}">
            </div>

            <button type="submit" class="button button-full">Perbarui Program Kerja</button>
        </form>
    </div>
</body>
</html>
