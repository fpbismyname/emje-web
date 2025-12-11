<x-layouts.client-app title="Pembayaran cicilan - {{ $cicilan->formatted_tanggal_pembayaran }}">

    {{-- Form --}}
    <form
        action="{{ route('client.pelatihan.pembayaran_pelatihan.submit-bayar-cicilan', [$id_pelatihan_diikuti, $cicilan->id]) }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        {{-- Data pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Nama Gelombang --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Gelombang</legend>
                <p class="w-full">{{ $cicilan->formatted_nominal }}</p>
            </fieldset>

            {{-- Bukti pembayaran --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Bukti pembayaran</legend>
                <input type="file" name="bukti_pembayaran" class="file-input file w-full validator" required />
                <p class="validator-hint hidden">
                    Bukti pembayaran wajib dilampirkan
                </p>
                @error('bukti_pembayaran')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>

        </div>

        {{-- Action  --}}
        <div class="grid place-items-center mt-4">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Bayar</button>
                <a href="{{ route('client.pelatihan.pembayaran-pelatihan.show', [$id_pelatihan_diikuti]) }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.client-app>
