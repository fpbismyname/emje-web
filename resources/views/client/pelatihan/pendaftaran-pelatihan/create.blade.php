<x-layouts.client-app title="Pendaftaran pelatihan">
    {{-- Info --}}
    <div class="flex flex-col">
        <p>
            Silakan lengkapi formulir pendaftaran pelatihan berikut ini. Pastikan data yang Anda masukkan sudah benar
            sebelum mengirimkan formulir.
        </p>
    </div>

    {{-- Form --}}
    <form
        action="{{ route('client.pelatihan.pendaftaran-pelatihan.store', ['gelombang_id' => request('gelombang_id')]) }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @method('post')

        {{-- Data pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            <div class="grid md:col-span-2">
                <h6>Data pelatihan</h6>
            </div>

            {{-- Nama Gelombang --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Gelombang</legend>
                <p class="w-full">{{ $datas->nama_gelombang }}</p>
            </fieldset>

            {{-- Sesi Gelombang --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Sesi Gelombang</legend>
                <p class="w-full">{{ $datas->sesi->label() }}</p>
            </fieldset>

            {{-- Biaya pelatihan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Biaya pelatihan</legend>
                <p class="w-full">{{ $datas->pelatihan->formatted_nominal_biaya }}</p>
            </fieldset>

            {{-- DP pelatihan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nominal DP</legend>
                <p class="w-full">{{ $datas->pelatihan->formatted_nominal_dp }}</p>
            </fieldset>

            {{-- Tanggal Mulai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal Mulai</legend>
                <p class="w-full">{{ $datas->formatted_tanggal_mulai }}</p>
            </fieldset>

            {{-- Tanggal Selesai --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal Selesai</legend>
                <p class="w-full">{{ $datas->formatted_tanggal_selesai }}</p>
            </fieldset>
        </div>

        <div class="divider"></div>

        {{-- Pembayaran pelatihan  --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4" x-data="{ skema: '{{ old('skema_pembayaran') }}' }" x-cloak>
            <div class="grid md:col-span-2">
                <h6>Pembayaran pelatihan</h6>
            </div>

            {{-- Skema pembayaran --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tipe pembayaran pelatihan</legend>
                <select name="skema_pembayaran" class="select w-full validator" x-model="skema" required>
                    <option value="" selected disabled>Pilih tipe pembayaran</option>
                    @foreach (App\Enums\Pelatihan\SkemaPembayaranEnum::cases() as $skema)
                        <option value="{{ $skema->value }}" @if (old('skema_pembayaran') === $skema->value) selected @endif>
                            {{ $skema->label() }}</option>
                    @endforeach
                </select>
                <p class="validator-hint hidden">
                    Tipe pembayaran wajib diisi
                </p>
                @error('skema_pembayaran')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Tenor cicilan --}}
            <fieldset class="fieldset" x-show="skema === 'cicilan'">
                <legend class="fieldset-legend">Tenor cicilan</legend>
                <select name="tenor" class="select w-full validator" x-bind:required="skema === 'cicilan'">
                    <option value="" selected disabled>Pilih tenor cicilan</option>
                    @foreach (App\Enums\Pelatihan\TenorCicilanPelatihanEnum::cases() as $tenor)
                        <option value="{{ $tenor->value }}" @if (old('tenor') === $tenor->value) selected @endif>
                            {{ $tenor->label() }}</option>
                    @endforeach
                </select>
                <p class="validator-hint hidden">
                    Tenor cicilan wajib diisi
                </p>
                @error('skema_pembayaran')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Bukti pembayaran --}}
            <fieldset class="fieldset" x-show="skema === 'cicilan'">
                <legend class="fieldset-legend">Bukti pembayaran DP</legend>
                <input type="file" name="bukti_pembayaran_dp" class="file-input file w-full validator"
                    x-bind:required="skema === 'cicilan'" />
                <p class="validator-hint hidden">
                    Bukti pembayaran DP wajib dilampirkan
                </p>
                @error('bukti_pembayaran_dp')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>

            {{-- Bukti pembayaran --}}
            <fieldset class="fieldset" x-show="skema === 'cash'">
                <legend class="fieldset-legend">Bukti pembayaran cash</legend>
                <input type="file" name="bukti_pembayaran_cash" class="file-input file w-full validator"
                    x-bind:required="skema
                    === 'cash'" />
                <p class="validator-hint hidden">
                    Bukti pembayaran cash wajib dilampirkan
                </p>
                @error('bukti_pembayaran_cash')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>

        {{-- Action  --}}
        <div class="grid place-items-center mt-4">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Daftar</button>
                <a href="{{ route('client.pelatihan.daftar-pelatihan.show', [$datas->id]) }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.client-app>
