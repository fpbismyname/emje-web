<x-layouts.admin-app title="Edit pelatihan">
    <form action="{{ route('admin.pelatihan.update', $pelatihan->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('put')

        {{-- Data pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Nama Pelatihan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Pelatihan</legend>
                <input type="text" name="nama_pelatihan" required
                    value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan) }}" class="input validator w-full">
                <p class="validator-hint hidden text-error">Nama pelatihan wajib diisi.</p>
                @error('nama_pelatihan')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Nominal Biaya --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nominal Biaya <small
                        id="preview-nominal-biaya">{{ $pelatihan->formatted_nominal_biaya ?? '' }}</small></legend>
                <input type="number" name="nominal_biaya" required
                    oninput="window.render_currency_to(this,'preview-nominal-biaya')"
                    value="{{ old('nominal_biaya', $pelatihan->nominal_biaya) }}" min="0"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Nominal biaya wajib diisi.</p>
                @error('nominal_biaya')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Durasi (Bulan) --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Durasi (Bulan)</legend>
                <input type="number" name="durasi_bulan" required
                    value="{{ old('durasi_bulan', $pelatihan->durasi_bulan) }}" min="1"
                    class="input validator w-full">
                <p class="validator-hint hidden text-error">Durasi pelatihan wajib diisi.</p>
                @error('durasi_bulan')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Kategori Pelatihan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Kategori Pelatihan</legend>
                <select name="kategori_pelatihan" required class="select validator w-full">
                    <option value="" disabled>Pilih kategori</option>
                    @foreach (App\Enums\Pelatihan\KategoriPelatihanEnum::cases() as $kategori)
                        <option value="{{ $kategori->value }}"
                            {{ old('kategori_pelatihan', $pelatihan->kategori_pelatihan->value ?? null) == $kategori->value ? 'selected' : '' }}>
                            {{ $kategori->label() }}
                        </option>
                    @endforeach
                </select>
                <p class="validator-hint hidden text-error">Kategori wajib dipilih.</p>
                @error('kategori_pelatihan')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Deskripsi --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Deskripsi</legend>
                <textarea name="deskripsi" required class="textarea validator w-full" rows="4">{{ old('deskripsi', $pelatihan->deskripsi) }}</textarea>
                <p class="validator-hint hidden text-error">Deskripsi wajib diisi.</p>
                @error('deskripsi')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Status --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Status</legend>
                <select name="status" required class="select validator w-full">
                    <option value="" disabled>Pilih status</option>
                    <option value="aktif" {{ old('status', $pelatihan->status) == 'aktif' ? 'selected' : '' }}>Aktif
                    </option>
                    <option value="nonaktif" {{ old('status', $pelatihan->status) == 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif</option>
                </select>
                <p class="validator-hint hidden text-error">Status wajib dipilih.</p>
                @error('status')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>

        {{-- Action  --}}
        <div class="grid place-items-center">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
