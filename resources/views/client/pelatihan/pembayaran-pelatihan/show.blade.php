<x-layouts.client-app title="{{ $pelatihan_diikuti->pendaftaran_pelatihan->pelatihan->nama_pelatihan }}">
    {{-- Data gelombang pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">

        <div class="grid md:col-span-2">
            <h6>Data pelatihan</h6>
        </div>

        {{-- Nama Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Gelombang</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->nama_gelombang }}</p>
        </fieldset>

        {{-- Sesi Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sesi Gelombang</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->sesi->label() }}</p>
        </fieldset>

        {{-- Biaya pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Biaya pelatihan</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->pelatihan->formatted_nominal_biaya }}</p>
        </fieldset>

        {{-- Nominal DP pendaftaran --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nominal DP pendaftaran</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->pelatihan->formatted_nominal_dp }}</p>
        </fieldset>

        {{-- Tanggal Mulai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Mulai</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->formatted_tanggal_mulai }}</p>
        </fieldset>

        {{-- Tanggal Selesai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Selesai</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->formatted_tanggal_selesai }}</p>
        </fieldset>

        {{-- Maksimal peserta --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kuota peserta pelatihan</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->total_maksimal_peserta }}</p>
        </fieldset>

    </div>

    <div class="divider"></div>

    <div class="flex flex-col w-full gap-4">
        <div class="grid md:col-span-2">
            <h6>Histori pembayaran</h6>
        </div>
        <ul class="list bg-base-200 rounded-box">
            @foreach ($pelatihan_diikuti->pendaftaran_pelatihan->pembayaran_pelatihan as $pembayaran)
                <li class="list-row">
                    <div class="tabular-nums">
                        {{ $loop->iteration }}
                    </div>
                    <div class="list-col-grow">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-col">
                                <h6>{{ $pembayaran->formatted_nominal }}</h6>
                                <small>Pembayaran {{ $pembayaran->jenis_pembayaran->label() }}</small>
                                <small>Jatuh tempo : {{ $pembayaran->formatted_tanggal_pembayaran }}</small>
                            </div>
                            <div class="badge badge-sm badge-primary">{{ $pembayaran->status->label() }}</div>
                        </div>
                    </div>
                    @if ($pembayaran->bukti_pembayaran)
                        <a class="btn btn-primary btn-sm" target="_blank"
                            href="{{ route('storage.private.show', ['file' => $pembayaran->bukti_pembayaran]) }}">
                            Bukti pembayaran
                        </a>
                    @else
                        <a class="btn btn-primary btn-sm"
                            href="{{ route('client.pelatihan.pembayaran_pelatihan.bayar-cicilan', [$pelatihan_diikuti->id, $pembayaran->id]) }}">
                            Bayar cicilan
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>


    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('client.pelatihan.pembayaran-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.client-app>
