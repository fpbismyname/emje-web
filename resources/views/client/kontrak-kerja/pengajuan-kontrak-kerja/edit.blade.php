<x-layouts.client-app title="Edit pengajuan kontrak kerja">
    <form action="{{ route('client.kontrak-kerja.pengajuan-kontrak-kerja.update', [$datas->id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        {{-- Surat pengajuan kontrak kerja --}}
        <div class="grid md:grid-cols-1 gap-4 rounded-box">

            {{-- Sumber dana --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Sumber dana pemberangkatan</legend>
                <select name="sumber_dana" class="select w-full" required>
                    <option value="" selected disabled>Pilih sumber dana pemberangkatan</option>
                    @foreach (App\Enums\KontrakKerja\SumberDanaEnum::cases() as $sumber)
                        <option value="{{ $sumber->value }}" @if (old('sumber_dana', $datas->sumber_dana->value) === $sumber->value) selected @endif>
                            {{ $sumber->label() }}</option>
                    @endforeach
                </select>
            </fieldset>

            {{-- Surat pengajuan kontrak kerja --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Surat pengajuan kontrak (Upload surat untuk mengganti surat pengajuan
                    kontrak kerja)</legend>
                <input type="file" name="surat_pengajuan_kontrak" class="file-input w-full validator" required />
                <p class="validator-hint hidden">
                    Surat pengajuan kontrak wajib dilampirkan
                </p>
                @error('surat_pengajuan_kontrak')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>


        {{-- Action  --}}
        <div class="grid place-items-center mt-4">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('client.kontrak-kerja.pengajuan-kontrak-kerja.show', [$datas->id]) }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.client-app>
