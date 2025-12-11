<x-layouts.client-app title="Pelatihan diikuti">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="kategori_pelatihan" class="select">
                <option value="">Pilih kategori pelatihan</option>
                @foreach (App\Enums\Pelatihan\KategoriPelatihanEnum::cases() as $status)
                    <option value="{{ $status->value }}" @if (request('kategori_pelatihan') === $status->value) selected @endif>
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
                                {{ $item->gelombang_pelatihan->nama_gelombang }}
                                <small>Periode : {{ $item->gelombang_pelatihan->formatted_tanggal_mulai }} -
                                    {{ $item->gelombang_pelatihan->formatted_tanggal_selesai }}</small>
                                <div>
                                    <div class="flex flex-row gap-4">
                                        <div class="badge badge-sm badge-primary">
                                            {{ $item->pendaftaran_pelatihan->pelatihan->kategori_pelatihan->label() }}
                                        </div>
                                        <div class="badge badge-sm badge-secondary">
                                            {{ $item->status->label() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-row gap-2">
                                <a href="{{ route('client.pelatihan.pelatihan-diikuti.show', [$item->id]) }}"
                                    class="btn btn-primary">Lihat</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <li class="list-row">
                    <div>
                        Tidak ada data pelatihan tersedia.
                    </div>
                </li>
            @endif
        </div>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>
</x-layouts.client-app>
