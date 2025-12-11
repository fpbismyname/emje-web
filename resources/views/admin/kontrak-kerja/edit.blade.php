<x-layouts.admin-app title="Edit kontrak kerja">
    <form action="{{ route('admin.kontrak-kerja.update', $kontrak_kerja->id) }}" method="POST" class="space-y-4"
        enctype="multipart/form-data">
        @csrf
        @method('put')

        {{-- Data kontrak kerja --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Nama Perusahaan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Perusahaan</legend>
                <input type="text" name="nama_perusahaan" required
                    value="{{ old('nama_perusahaan', $kontrak_kerja->nama_perusahaan) }}"
                    class="input validator w-full" />
                <p class="validator-hint hidden text-error">
                    Nama perusahaan wajib diisi.
                </p>
                @error('nama_perusahaan')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Gaji Terendah --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">
                    Gaji terendah
                    <small id="preview-gaji-terendah">
                        {{ $kontrak_kerja->formatted_gaji_terendah }}
                    </small>
                </legend>
                <input type="number" name="gaji_terendah" required
                    oninput="window.render_currency_to(this,'preview-gaji-terendah')"
                    value="{{ old('gaji_terendah', $kontrak_kerja->gaji_terendah ?? $kontrak_kerja->formatted_gaji_terendah) }}"
                    min="1000000" class="input validator w-full" />
                <p class="validator-hint hidden text-error">
                    Gaji terendah wajib diisi.
                </p>
                @error('gaji_terendah')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Gaji Tertinggi --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">
                    Gaji tertinggi
                    <small id="preview-gaji-tertinggi">
                        {{ $kontrak_kerja->formatted_gaji_tertinggi }}
                    </small>
                </legend>
                <input type="number" name="gaji_tertinggi" required
                    oninput="window.render_currency_to(this,'preview-gaji-tertinggi')"
                    value="{{ old('gaji_tertinggi', $kontrak_kerja->gaji_tertinggi ?? $kontrak_kerja->formatted_gaji_tertinggi) }}"
                    min="1000000" class="input validator w-full" />
                <p class="validator-hint hidden text-error">
                    Gaji tertinggi wajib diisi.
                </p>
                @error('gaji_tertinggi')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Status --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Status</legend>
                <select name="status" required class="select validator w-full">
                    <option value="" selected disabled>Pilih status</option>
                    @foreach (App\Enums\KontrakKerja\StatusKontrakKerjaEnum::cases() as $status)
                        <option value="{{ $status->value }}"
                            {{ old('status', $kontrak_kerja->status->value ?? $kontrak_kerja->status) == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                <p class="validator-hint hidden text-error">
                    Status wajib dipilih.
                </p>
                @error('status')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Kategori kontrak kerja --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Kategori kontrak kerja</legend>
                <select name="kategori_kontrak_kerja" required class="select validator w-full">
                    <option value=""
                        {{ old('kategori_kontrak_kerja', $kontrak_kerja->kategori_kontrak_kerja->value) ? '' : 'selected' }}
                        disabled>Pilih
                        kategori kontrak kerja
                    </option>
                    @foreach (App\Enums\Pelatihan\KategoriPelatihanEnum::cases() as $kategori)
                        <option value="{{ $kategori->value }}"
                            {{ old('kategori_kontrak_kerja') == $kategori->value ? 'selected' : '' }}>
                            {{ $kategori->label() }}
                        </option>
                    @endforeach
                </select>
                <p class="validator-hint hidden text-error">
                    Kategori kontrak kerja wajib dipilih.
                </p>
                @error('kategori_kontrak_kerja')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Durasi Kontrak Kerja --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Durasi Kontrak Kerja (Tahun)</legend>
                <div class="form-control">
                    <input type="number" name="durasi_kontrak_kerja" required
                        value="{{ old('durasi_kontrak_kerja', $kontrak_kerja->durasi_kontrak_kerja) }}" min="1"
                        class="input validator w-full" />
                    <p class="validator-hint hidden text-error">
                        Durasi kontrak kerja wajib diisi.
                    </p>
                    @error('durasi_kontrak_kerja')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
            </fieldset>

            {{-- Maksimal pelamar --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Maksimal pelamar</legend>
                <div class="form-control">
                    <input type="number" name="maksimal_pelamar" required
                        value="{{ old('maksimal_pelamar', $kontrak_kerja->maksimal_pelamar) }}" min="1"
                        class="input validator w-full" />
                    <p class="validator-hint hidden text-error">
                        Maksimal pelamar kerja wajib diisi.
                    </p>
                    @error('maksimal_pelamar')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
            </fieldset>

            {{-- Deskripsi --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Deskripsi</legend>
                <div class="form-control">
                    <textarea name="deskripsi" required class="textarea validator w-full" rows="4">{{ old('deskripsi', $kontrak_kerja->deskripsi) }}</textarea>
                    <p class="validator-hint hidden text-error">
                        Deskripsi wajib diisi.
                    </p>
                    @error('deskripsi')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
            </fieldset>

            {{-- Surat kontrak --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Surat kontrak (Upload untuk mengganti surat kontrak)</legend>
                <input type="file" name="surat_kontrak" class="file-input w-full validator" />
                <p class="validator-hint hidden">
                    Surat kontrak wajib dilampirkan
                </p>
                @error('surat_kontrak')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>

        {{-- Action  --}}
        <div class="grid place-items-center">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kontrak-kerja.index') }}" class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
