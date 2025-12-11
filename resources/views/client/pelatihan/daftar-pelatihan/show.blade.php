<x-layouts.client-app title="{{ $gelombang_pelatihan->nama_gelombang }}">
    {{-- Data gelombang pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        {{-- Nama Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Gelombang</legend>
            <p class="w-full">{{ $gelombang_pelatihan->nama_gelombang }}</p>
        </fieldset>

        {{-- Sesi Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sesi Gelombang</legend>
            <p class="w-full">{{ $gelombang_pelatihan->sesi->label() }}</p>
        </fieldset>

        {{-- Biaya pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Biaya pelatihan</legend>
            <p class="w-full">{{ $gelombang_pelatihan->pelatihan->formatted_nominal_biaya }}</p>
        </fieldset>

        {{-- Nominal DP pendaftaran --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nominal DP pendaftaran</legend>
            <p class="w-full">{{ $gelombang_pelatihan->pelatihan->formatted_nominal_dp }}</p>
        </fieldset>

        {{-- Tanggal Mulai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Mulai</legend>
            <p class="w-full">{{ $gelombang_pelatihan->formatted_tanggal_mulai }}</p>
        </fieldset>

        {{-- Tanggal Selesai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Selesai</legend>
            <p class="w-full">{{ $gelombang_pelatihan->formatted_tanggal_selesai }}</p>
        </fieldset>

        {{-- Maksimal peserta --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kuota peserta pelatihan</legend>
            <p class="w-full">{{ $gelombang_pelatihan->total_maksimal_peserta }}</p>
        </fieldset>

    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            @if (auth()->user()->dapat_mengajukan_pelatihan)
                <div class="{{ auth()->user()->profil_lengkap ? '' : 'tooltip' }}"
                    data-tip="Lengkapi data profil untuk melanjutkan pendaftaran">
                    @if (auth()->user()->profil_lengkap)
                        <a href="{{ route('client.pelatihan.pendaftaran-pelatihan.create', ['gelombang_id' => $gelombang_pelatihan->id]) }}"
                            class="btn btn-primary">Daftar</a>
                    @else
                        <a class="btn btn-error" href="{{ route('client.pengaturan.edit') }}">
                            <x-lucide-info class="w-4" />
                        </a>
                    @endif
                </div>
            @else
                <div class="tooltip" data-tip="Selesaikan pelatihan sebelumnya untuk daftar pelatihan ini">
                    <a class="btn btn-info" href="{{ route('client.pelatihan.pelatihan-diikuti.index') }}">
                        <x-lucide-info class="w-4" />
                    </a>
                </div>
            @endif
            <a href="{{ route('client.pelatihan.daftar-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.client-app>
