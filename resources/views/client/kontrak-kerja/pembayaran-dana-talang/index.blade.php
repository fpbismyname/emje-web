<x-layouts.client-app title="Pembayaran dana talang">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
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
                                {{ $item->pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan }}
                                <small>
                                    Durasi kontrak :
                                    {{ $item->pengajuan_kontrak_kerja->kontrak_kerja->formatted_durasi_kontrak_kerja }}
                                </small>
                                <small>
                                    Sumber dana pemberangkatan :
                                    {{ $item->pengajuan_kontrak_kerja->sumber_dana->label() }}
                                </small>
                                <div class="flex flex-row gap-2">
                                    <div class="badge badge-sm badge-primary">
                                        {{ $item->pengajuan_kontrak_kerja->kontrak_kerja->kategori_kontrak_kerja->label() }}
                                    </div>
                                    <small class="badge badge-sm badge-secondary">
                                        {{ $item->pengajuan_kontrak_kerja->pembayaran_dana_talang_lunas == true ? 'Lunas' : 'Belum Lunas' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-row gap-2">
                                <a href="{{ route('client.kontrak-kerja.pembayaran-dana-talang.show', [$item->id]) }}"
                                    class="btn btn-primary">Lihat</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <li class="list-row">
                    <div>
                        Tidak ada data pembayaran dana talang tersedia.
                    </div>
                </li>
            @endif
        </div>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>
</x-layouts.client-app>
