<x-layouts.client-app title="Daftar kontrak kerja">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="kategori_kontrak_kerja" class="select">
                <option value="">Pilih kategori kontrak kerja</option>
                @foreach (App\Enums\Pelatihan\KategoriPelatihanEnum::cases() as $status)
                    <option value="{{ $status->value }}" @if (request('kategori_kontrak_kerja') === $status->value) selected @endif>
                        {{ $status->label() }}</option>
                @endforeach
            </select>
            <input type="text" class="input" name="search" value="{{ request('search') }}"
                placeholder="Cari pelatihan" />
            <button class="btn btn-primary">
                <x-lucide-search class="w-4" />
            </button>
        </form>
    </div>

    {{-- Datatable --}}
    <div class="flex flex-col gap-4">
        <div class="list bg-base-200 rounded-box shadow">
            @if ($datas->isNotEmpty())
                @foreach ($datas as $item)
                    <li class="list-row">
                        <div class="tabular-nums">
                            {{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}
                        </div>
                        <div class="list-col-grow">
                            <div class="flex flex-col gap-2">
                                {{ $item->nama_perusahaan }}
                                <div class="badge badge-sm badge-primary">
                                    {{ $item->kategori_kontrak_kerja->label() }}
                                </div>
                                <div class="flex flex-col">
                                    <small>
                                        Rentang gaji : {{ $item->formatted_gaji_terendah }} -
                                        {{ $item->formatted_gaji_tertinggi }}
                                    </small>
                                    <small>
                                        Durasi kontrak : {{ $item->formatted_durasi_kontrak_kerja }}
                                    </small>
                                    <small>
                                        Masimal pelamar
                                        : {{ $item->formatted_maksimal_pelamar }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-row gap-2">
                                <a href="{{ route('client.kontrak-kerja.daftar-kontrak-kerja.show', [$item->id]) }}"
                                    class="btn btn-primary">Lihat</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <li class="list-row">
                    <div>
                        Tidak ada data kontrak kerja.
                    </div>
                </li>
            @endif
        </div>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>
</x-layouts.client-app>
