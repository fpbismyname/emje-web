<x-layouts.admin-app title="Buat jadwal ujian - {{ $gelombang_pelatihan->nama_gelombang }}">
    <form action="{{ route('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.store', [$gelombang_pelatihan->id]) }}"
        method="POST" class="space-y-4">
        @csrf
        @method('post')

        {{-- Data pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Nama ujian --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama ujian</legend>
                <input type="text" name="nama_ujian" required value="{{ old('nama_ujian') }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Nama ujian wajib diisi.</p>
                @error('nama_ujian')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Lokasi --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Lokasi ujian</legend>
                <input type="text" name="lokasi" required value="{{ old('lokasi') }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Lokasi ujian wajib diisi.</p>
                @error('lokasi')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal mulai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal mulai</legend>
                <input type="date" name="tanggal_mulai" required value="{{ old('tanggal_mulai') }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Tanggal mulai wajib diisi.</p>
                @error('tanggal_mulai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal selesai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal selesai</legend>
                <input type="date" name="tanggal_selesai" required value="{{ old('tanggal_selesai') }}"
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
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{ route('admin.gelombang-pelatihan.show', [$gelombang_pelatihan->id]) }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
