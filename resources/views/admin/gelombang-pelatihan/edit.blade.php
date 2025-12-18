<x-layouts.admin-app title="Edit gelombang pelatihan">
    <form action="{{ route('admin.gelombang-pelatihan.update', $gelombang_pelatihan->id) }}" method="POST"
        class="space-y-4">
        @csrf
        @method('put')

        {{-- Data gelombang pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Nama Gelombang --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Gelombang</legend>
                <input type="text" name="nama_gelombang" required
                    value="{{ old('nama_gelombang', $gelombang_pelatihan->nama_gelombang) }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Nama gelombang wajib diisi.</p>
                @error('nama_gelombang')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal Mulai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal Mulai</legend>
                <input type="date" name="tanggal_mulai" required
                    value="{{ old('tanggal_mulai', $gelombang_pelatihan->date_time_tanggal_mulai) }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Tanggal mulai wajib diisi.</p>
                @error('tanggal_mulai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal Selesai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal Selesai</legend>
                <input type="date" name="tanggal_selesai" required
                    value="{{ old('tanggal_selesai', $gelombang_pelatihan->date_time_tanggal_selesai) }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Tanggal selesai wajib diisi.</p>
                @error('tanggal_selesai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Maksimal peserta --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Maksimal peserta</legend>
                <input type="number" min="1" max="1000" name="maksimal_peserta" required
                    value="{{ old('maksimal_peserta', $gelombang_pelatihan->maksimal_peserta) }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Maksimal peserta wajib diisi.</p>
                @error('maksimal_peserta')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

        </div>

        {{-- Action  --}}
        <div class="grid place-items-center">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.gelombang-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
