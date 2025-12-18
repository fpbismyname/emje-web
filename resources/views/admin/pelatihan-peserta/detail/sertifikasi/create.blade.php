<x-layouts.admin-app
    title="Upload sertifikat peserta - {{ $pelatihan_peserta->gelombang_pelatihan->pelatihan->nama_pelatihan }}">
    {{-- Data pelatihan --}}
    <form
        action="{{ route('admin.pelatihan-peserta.detail.sertifikasi.store', [$profil_user->id, $pelatihan_peserta->id]) }}"
        method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf
        @method('post')

        {{-- Data gelombang pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- jenis sertifikat --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Jenis sertifikat</legend>
                <select name="jenis_sertifikat" class="select w-full validator">
                    <option value="" selected disabled>Pilih jenis sertifikat</option>
                    @foreach (App\Enums\Pelatihan\JenisSertifikatEnum::cases() as $jenis)
                        <option value="{{ $jenis->value }}" @selected(old('jenis_sertifikat') == $jenis->value)>
                            {{ $jenis->label() }}
                        </option>
                    @endforeach
                    </option>
                </select>
                <p class="validator-hint hidden text-error">Jenis sertifikat wajib diisi.</p>
                @error('jenis_sertifikat')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Sertifikat --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Sertifikat</legend>
                <input type="file" name="sertifikat" required value="{{ old('nama_materi') }}"
                    class="file-input validator w-full">
                <p class="validator-hint hidden text-error">Sertifikat wajib diisi.</p>
                @error('sertifikat')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>

        {{-- Action  --}}
        <div class="grid place-items-center">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{ route('admin.pelatihan-peserta.detail.show', [$profil_user->id, $pelatihan_peserta->id]) }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
