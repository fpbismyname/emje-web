<x-layouts.client-app title="Kontrak kerja diikuti">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="kategori_kontrak_kerja" class="select">
                <option value="">Pilih kategori kontrak kerja</option>
                @foreach (App\Enums\Pelatihan\KategoriPelatihanEnum::cases() as $kategori)
                    <option value="{{ $kategori->value }}" @if (request('kategori_kontrak_kerja') === $kategori->value) selected @endif>
                        {{ $kategori->label() }}</option>
                @endforeach
            </select>
            <input type="text" class="input" name="search" value="{{ request('search') }}"
                placeholder="Cari kontrak kerja..." />
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
                                {{ $item->pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan }}
                                <div class="flex flex-row gap-4">
                                    <div class="badge badge-sm badge-primary">
                                        {{ $item->pengajuan_kontrak_kerja->kontrak_kerja->kategori_kontrak_kerja->label() }}
                                    </div>
                                    <div class="badge badge-sm badge-secondary">
                                        {{ $item->status->label() }}
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <small>
                                        Rentang gaji :
                                        {{ $item->pengajuan_kontrak_kerja->kontrak_kerja->formatted_gaji_terendah }} -
                                        {{ $item->pengajuan_kontrak_kerja->kontrak_kerja->formatted_gaji_tertinggi }}
                                    </small>
                                    <small>
                                        Durasi kontrak :
                                        {{ $item->pengajuan_kontrak_kerja->kontrak_kerja->formatted_durasi_kontrak_kerja }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-row gap-2">
                                <a href="{{ route('client.kontrak-kerja.kontrak-kerja-diikuti.show', [$item->id]) }}"
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
