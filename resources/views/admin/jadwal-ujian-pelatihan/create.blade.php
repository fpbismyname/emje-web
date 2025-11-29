<x-layouts.admin-app title="Tambah pelatihan">
    <form action="{{ route('admin.jadwal-ujian-pelatihan.store') }}" method="POST" class="space-y-4">
        @csrf
        @method('post')

        {{-- Data pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Nama ujian --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama ujian</legend>
                <input type="text" name="nama_pelatihan" required value="{{ old('nama_pelatihan') }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Nama pelatihan wajib diisi.</p>
                @error('nama_pelatihan')
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
                <input type="datetime-local" name="tanggal_mulai" required value="{{ old('tanggal_mulai') }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Tanggal mulai wajib diisi.</p>
                @error('tanggal_mulai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal selesai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal selesai</legend>
                <input type="datetime-local" name="tanggal_selesai" required value="{{ old('tanggal_selesai') }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Tanggal selesai wajib diisi.</p>
                @error('tanggal_selesai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Gelombang pelatihan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Gelombang pelatihan</legend>
                <select name="gelombang_pelatihan_id" required class="select validator w-full">
                    <option value="" disabled selected>Pilih gelombang pelatihan</option>
                    @foreach ($gelombang_pelatihan as $gelombang)
                        <option value="{{ $gelombang->id }}"
                            {{ old('gelombang_pelatihan_id') == $gelombang->id ? 'selected' : '' }}>
                            {{ $gelombang->nama_gelombang }}</option>
                    @endforeach
                </select>
                <p class="validator-hint hidden text-error">Nama pelatihan wajib diisi.</p>
                @error('gelombang_pelatihan_id')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>


        </div>

        {{-- Action  --}}
        <div class="grid place-items-center">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
