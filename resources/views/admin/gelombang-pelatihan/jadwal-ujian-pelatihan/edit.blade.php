<x-layouts.admin-app title="Edit jadwal ujian - {{ $jadwal_ujian->nama_ujian }}">
    <form
        action="{{ route('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.update', [$jadwal_ujian->gelombang_pelatihan->id, $jadwal_ujian->id]) }}"
        method="POST" class="space-y-4">
        @csrf
        @method('put')

        {{-- Data pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Nama ujian --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama ujian</legend>
                <input type="text" name="nama_ujian" required value="{{ old('nama_ujian', $jadwal_ujian->nama_ujian) }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Nama ujian wajib diisi.</p>
                @error('nama_ujian')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Jenis ujian --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Jenis ujian</legend>
                <select name="jenis_ujian" class="select w-full validator">
                    <option value="" selected disabled>Pilih materi</option>
                    @foreach (App\Enums\Pelatihan\JenisUjianEnum::cases() as $jenis_ujian)
                        <option value="{{ $jenis_ujian->value }}" @selected(old('jenis_ujian', $jadwal_ujian->jenis_ujian->value) == $jenis_ujian->value)>
                            {{ $jenis_ujian->label() }}
                        </option>
                    @endforeach
                    </option>
                </select>
                <p class="validator-hint hidden text-error">Nama materi wajib diisi.</p>
                @error('nama_materi')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Lokasi --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Lokasi ujian</legend>
                <input type="text" name="lokasi" required value="{{ old('lokasi', $jadwal_ujian->lokasi) }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Lokasi ujian wajib diisi.</p>
                @error('lokasi')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal mulai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal mulai</legend>
                <input type="date" name="tanggal_mulai" required
                    value="{{ old('tanggal_mulai', $jadwal_ujian->date_tanggal_mulai) }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Tanggal mulai wajib diisi.</p>
                @error('tanggal_mulai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal selesai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal selesai</legend>
                <input type="date" name="tanggal_selesai" required
                    value="{{ old('tanggal_selesai', $jadwal_ujian->date_tanggal_selesai) }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Tanggal selesai wajib diisi.</p>
                @error('tanggal_selesai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>

        {{-- Action  --}}
        <div class="grid place-items-center">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.gelombang-pelatihan.show', [$jadwal_ujian->gelombang_pelatihan->id]) }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
