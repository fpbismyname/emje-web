<x-layouts.client-app title="Detail pendaftaran pelatihan">

    {{-- Form --}}
    <form
        action="{{ route('client.pelatihan.pendaftaran-pelatihan.store', ['kontrak_kerja_id' => request('kontrak_kerja_id')]) }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        {{-- Data pelatihan --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            <div class="grid md:col-span-2">
                <h6>Data pelatihan</h6>
            </div>

            {{-- Nama perusahaan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Gelombang</legend>
                <p>{{ $datas-> }}</p>
            </fieldset>
        </div>

        <div class="divider"></div>

        {{-- Pembayaran pelatihan  --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4" x-data="{ skema: '{{ old('skema_pembayaran', $datas->skema_pembayaran) }}' }" x-cloak>
            <div class="grid md:col-span-2">
                <h6>Pembayaran pelatihan</h6>
            </div>

            {{-- Skema pembayaran --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tipe pembayaran pelatihan</legend>
                <p>{{ $datas->skema_pembayaran->label() }}</p>
            </fieldset>

            {{-- Tenor cicilan --}}
            <fieldset class="fieldset" x-show="skema === 'cicilan'">
                <legend class="fieldset-legend">Tenor cicilan</legend>
                <p>{{ old('tenor') ? App\Enums\Pelatihan\TenorCicilanPelatihanEnum::from(old('tenor'))->label() : $datas->tenor?->label() }}
                </p>
            </fieldset>

            {{-- Bukti pembayaran cicilan --}}
            <fieldset class="fieldset" x-show="skema === 'cicilan'">
                <legend class="fieldset-legend">Bukti pembayaran DP</legend>
                <p>{{ $datas->bukti_pembayaran_dp ?? '-' }}</p>
            </fieldset>

            {{-- Bukti pembayaran cash --}}
            <fieldset class="fieldset" x-show="skema === 'cash'">
                <legend class="fieldset-legend">Bukti pembayaran cash</legend>
                @if ($datas->pembayaran_pelatihan_cash()->exists())
                    <a target="_blank" class="link link-hover link-primary"
                        href="{{ route('storage.private.show', ['file' => $datas->pembayaran_pelatihan_cash->bukti_pembayaran]) }}">Lihat
                        selengkapnya</a>
                @else
                    <p>Tidak ada</p>
                @endif
            </fieldset>
        </div>

        <div class="divider"></div>

        {{-- Action  --}}
        <div class="grid place-items-center mt-4">
            <div class="flex flex-row gap-2">
                <a href="{{ route('client.pelatihan.pendaftaran-pelatihan.index') }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.client-app>
