<x-layouts.admin-app title="Detail pembayaran pelatihan">
    {{-- Data peserta --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data peserta</h6>
        </div>
        {{-- Nama peserta --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama peserta</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->users->profil_user->nama_lengkap }}</p>
        </fieldset>
        {{-- Jenis kelamin --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Jenis kelamin</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->users->profil_user->jenis_kelamin->label() }}</p>
        </fieldset>
        {{-- Pendidikan terakhir --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Pendidikan terakhir</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->users->profil_user->pendidikan_terakhir->label() }}</p>
        </fieldset>
        {{-- Tanggal lahir --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal lahir</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->users->profil_user->formatted_tanggal_lahir }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    {{-- Data pembayaran --}}
    <div class="flex flex-col p-4 gap-4">
        <div class="grid md:col-span-2">
            <h6>Data pembayaran</h6>
        </div>
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            {{-- Skema pembayaran --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Skema pembayaran</legend>
                <p class="py-2">{{ $pendaftaran_pelatihan->skema_pembayaran->label() }}</p>
            </fieldset>
            @if ($pendaftaran_pelatihan->tenor)
                {{-- Tenor cicilan --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Tenor cicilan</legend>
                    <p class="py-2">{{ $pendaftaran_pelatihan->tenor->label() }}</p>
                </fieldset>
            @endif
            {{-- Total biaya pelatihan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Total biaya pelatihan</legend>
                <p class="py-2">{{ $pendaftaran_pelatihan->pelatihan->formatted_nominal_biaya }}</p>
            </fieldset>
            {{-- Total terbayar --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Total biaya pelatihan</legend>
                <p class="py-2">{{ $pendaftaran_pelatihan->pelatihan->formatted_nominal_biaya }}</p>
            </fieldset>
            {{-- Status pembayaran pelatihan --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Status pembayaran pelatihan</legend>
                <p class="py-2">{{ $pendaftaran_pelatihan->pembayaran_pelatihan_lunas ? 'Lunas' : 'Belum lunas' }}</p>
            </fieldset>
        </div>
        <div class="grid md:col-span-2">
            <h6>Histori pembayaran</h6>
        </div>
        <ul class="list bg-base-200 rounded-box">
            @foreach ($pendaftaran_pelatihan->pembayaran_pelatihan as $pembayaran)
                <li class="list-row">
                    <div class="tabular-nums">
                        {{ $loop->iteration }}
                    </div>
                    <div class="list-col-grow">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-col">
                                <h6>{{ $pembayaran->formatted_nominal }}</h6>
                                <small>Pembayaran {{ $pembayaran->jenis_pembayaran->label() }}</small>
                            </div>
                            <div class="badge badge-sm badge-primary">{{ $pembayaran->status->label() }}</div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-sm" target="_blank"
                        href="{{ route('storage.private.show', ['file' => $pembayaran->bukti_pembayaran]) }}">
                        Bukti pembayaran
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('admin.pembayaran-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
