<x-layouts.admin-app title="Edit hasil ujian - {{ $jadwal_ujian_pelatihan->nama_ujian }}">
    {{-- Data pelatihan --}}
    <form
        action="{{ route('admin.pelatihan-peserta.detail.jadwal-ujian.hasil-ujian.update', [$id_profil_user, $id_pelatihan_peserta, $id_jadwal_ujian, $id_hasil_ujian]) }}"
        method="post" class="space-y-4">
        @csrf
        @method('put')


        {{-- Data gelombang pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">

            {{-- Nama materi --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama materi</legend>
                <input type="text" name="nama_materi" required
                    value="{{ old('nama_materi', $hasil_ujian_pelatihan->nama_materi) }}" class="input validator w-full">
                <p class="validator-hint hidden text-error">Nama materi wajib diisi.</p>
                @error('nama_materi')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Nilai ujian --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nilai ujian</legend>
                <input type="number" name="nilai" required value="{{ old('nilai', $hasil_ujian_pelatihan->nilai) }}"
                    step="0.01" min="1" max="100" class="input validator w-full">
                <p class="validator-hint hidden text-error">Nilai ujian wajib diisi.</p>
                @error('nilai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>


            {{-- Status ujian --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nilai ujian</legend>
                <p>{{ $hasil_ujian_pelatihan->status->label() }}</p>
            </fieldset>


        </div>

        {{-- Action  --}}
        <div class="grid place-items-center">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.pelatihan-peserta.detail.show', [$id_profil_user, $id_pelatihan_peserta]) }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
