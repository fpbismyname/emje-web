<x-layouts.admin-app title="Detail pelatihan peserta">
    {{-- Data peserta --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data peserta</h6>
        </div>
        {{-- Nama peserta --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama peserta</legend>
            <p class="py-2">{{ $profil_user->nama_lengkap }}</p>
        </fieldset>
        {{-- Jenis kelamin --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Jenis kelamin</legend>
            <p class="py-2">{{ $profil_user->jenis_kelamin->label() }}</p>
        </fieldset>
        {{-- Pendidikan terakhir --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Pendidikan terakhir</legend>
            <p class="py-2">{{ $profil_user->pendidikan_terakhir->label() }}</p>
        </fieldset>
        {{-- Tanggal lahir --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal lahir</legend>
            <p class="py-2">{{ $profil_user->formatted_tanggal_lahir }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    {{-- Data pelatihan --}}
    <div class="flex flex-col p-4 gap-4">
        <div class="grid md:col-span-2">
            <h6>Pelatihan diikuti</h6>
        </div>
        <ul class="list bg-base-200 rounded-box">
            @foreach ($pendaftaran_pelatihan as $pendaftaran)
                <li class="list-row">
                    <div class="tabular-nums">
                        {{ $loop->iteration + ($pendaftaran_pelatihan->currentPage() - 1) * $pendaftaran_pelatihan->perPage() }}
                    </div>
                    <div class="list-col-grow">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-col">
                                <h6>{{ $pendaftaran->pelatihan->nama_pelatihan }}</h6>
                                <small>Durasi pelatihan :
                                    {{ $pendaftaran->pelatihan->formatted_durasi_pelatihan }}</small>
                            </div>
                            <div class="badge badge-sm badge-primary">
                                {{ $pendaftaran->pelatihan_peserta?->status->label() ?? $pendaftaran->status->label() }}
                            </div>
                        </div>
                    </div>
                    @if ($pendaftaran->status === App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum::DITERIMA)
                        <a class="btn btn-primary btn-sm"
                            href="{{ route('admin.pelatihan-peserta.detail.show', [$profil_user->id, $pendaftaran->pelatihan_peserta->id]) }}">
                            Detail
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
        {{ $pendaftaran_pelatihan->links('vendor.pagination.daisyui') }}
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('admin.pelatihan-peserta.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
