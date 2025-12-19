<x-layouts.client-app title="{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan }}">
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">

        <div class="grid md:col-span-2">
            <h6>Data kontrak kerja</h6>
        </div>

        {{-- Nama Perusahaan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Perusahaan</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan }}</p>
        </fieldset>
        {{-- Rentang Gaji --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Rentang Gaji</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->formatted_rentang_gaji }}</p>
        </fieldset>
        {{-- Status --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Status</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->status->label() }}</p>
        </fieldset>
        {{-- Durasi Kontrak Kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi Kontrak Kerja</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->formatted_durasi_kontrak_kerja }}</p>
        </fieldset>
        {{-- Maksimal pelamar --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Maksimal pelamar</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->maksimal_pelamar }}</p>
        </fieldset>
        {{-- Surat kontrak --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Surat kontrak</legend>
            <a target="_blank"
                href="{{ route('storage.private.show', ['file' => $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->surat_kontrak]) }}"
                class="link link-hover link-primary">Lihat selengkapnya</a>
        </fieldset>
        {{-- Deskripsi --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Deskripsi</legend>
            <p class="whitespace-pre-line">
                {{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->deskripsi }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    <div class="flex flex-col w-full gap-4">
        <div class="grid md:col-span-2">
            <h6>Histori pembayaran</h6>
        </div>
        <ul class="list bg-base-200 rounded-box">
            @foreach ($kontrak_kerja_diikuti->pengajuan_kontrak_kerja->pembayaran_dana_talang as $pembayaran)
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
                            href="{{ route('client.kontrak-kerja.pembayaran-dana-talang.bayar-cicilan', [$kontrak_kerja_diikuti->id, $pembayaran->id]) }}">
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
            <a href="{{ route('client.kontrak-kerja.pembayaran-dana-talang.index') }}"
                class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.client-app>
