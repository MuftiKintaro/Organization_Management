<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Program Kerja - UKM Esports</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body style="background-color: #0b0f19; color: #f8fafc; font-family: 'Segoe UI', sans-serif; padding: 40px 20px;">

    <div style="max-width: 560px; margin: 0 auto; background: #131b2e; border: 1px solid #1e293b; border-radius: 16px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.6);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; padding-bottom: 14px; margin-bottom: 22px;">
            <h2 style="color: #06b6d4; margin: 0; font-size: 1.3rem;">🎯 Tambah Program Kerja</h2>
            <a href="{{ route('dashboard') }}" style="color: #94a3b8; font-size: 0.85rem;">← Kembali</a>
        </div>

        <form action="{{ route('programs.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="judul">Judul Program Kerja</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Valorant Campus Cup 2026">
                @error('judul')
                    <span style="color: #f87171; font-size: 12px; display: block; margin-top: 5px;">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label for="icon">Icon Emoji</label>
                    <select id="icon" name="icon" class="form-control-select" style="width: 100%;">
                        <option value="🏆" {{ old('icon') == '🏆' ? 'selected' : '' }}>🏆 Turnamen</option>
                        <option value="🎓" {{ old('icon') == '🎓' ? 'selected' : '' }}>🎓 Bootcamp / Pelatihan</option>
                        <option value="🎯" {{ old('icon') == '🎯' ? 'selected' : '' }}>🎯 Scrim / Seleksi</option>
                        <option value="⚙️" {{ old('icon') == '⚙️' ? 'selected' : '' }}>⚙️ Infrastruktur</option>
                        <option value="🎙️" {{ old('icon') == '🎙️' ? 'selected' : '' }}>🎙️ Caster / Media</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status Proker</label>
                    <select id="status" name="status" class="form-control-select" style="width: 100%;">
                        <option value="Perencanaan" {{ old('status') == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                        <option value="Sedang Berjalan" {{ old('status') == 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                        <option value="Terlaksana" {{ old('status') == 'Terlaksana' ? 'selected' : '' }}>Terlaksana</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="tanggal">Target Tanggal Pelaksanaan</label>
                <input type="text" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" placeholder="Contoh: 20 Desember 2026">
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Program Kerja</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan tujuan dan rincian kegiatan..." style="width: 100%; padding: 12px 14px; background-color: #0f172a; border: 1px solid #334155; border-radius: 8px; color: #f8fafc; font-size: 14px; outline: none; resize: vertical;">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span style="color: #f87171; font-size: 12px; display: block; margin-top: 5px;">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="button button-full">Simpan Program Kerja</button>
        </form>
    </div>

</body>
</html>
