<x-layouts.admin-app title="Tambah gelombang pelatihan">
    {{-- Data pelatihan --}}
    <form action="{{ route('admin.gelombang-pelatihan.store') }}" method="POST" class="space-y-4">
        @csrf
        @method('post')

        {{-- Data gelombang pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Nama Gelombang --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Gelombang</legend>
                <input type="text" name="nama_gelombang" required value="{{ old('nama_gelombang') }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Nama gelombang wajib diisi.</p>
                @error('nama_gelombang')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Pelatihan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Pelatihan</legend>
                <select name="pelatihan_id" required class="select validator w-full">
                    <option value="" selected disabled>Pilih pelatihan</option>
                    @foreach (App\Models\Pelatihan::get() as $pelatihan)
                        <option value="{{ $pelatihan->id }}" {{ old('pelatihan') == $pelatihan->id ? 'selected' : '' }}>
                            {{ $pelatihan->nama_pelatihan }}
                        </option>
                    @endforeach
                </select>
                <p class="validator-hint hidden text-error">Sesi gelombang wajib dipilih.</p>
                @error('pelatihan_id')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal Mulai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal Mulai</legend>
                <input type="date" name="tanggal_mulai" required value="{{ old('tanggal_mulai') }}"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Tanggal mulai wajib diisi.</p>
                @error('tanggal_mulai')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tanggal Selesai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal Selesai</legend>
                <input type="date" name="tanggal_selesai" required value="{{ old('tanggal_selesai') }}"
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
                    value="{{ old('maksimal_peserta') }}" class="input validator w-full">
                <p class="validator-hint hidden text-error">Maksimal peserta wajib diisi.</p>
                @error('maksimal_peserta')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

        </div>

        {{-- Action  --}}
        <div class="grid place-items-center">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{ route('admin.gelombang-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
