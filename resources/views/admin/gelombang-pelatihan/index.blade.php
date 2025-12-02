<x-layouts.admin-app title="Gelombang pelatihan">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="sesi" class="select">
                <option value="">Pilih sesi</option>
                @foreach (App\Enums\Pelatihan\SesiGelombangPelatihanEnum::cases() as $sesi)
                    <option value="{{ $sesi->value }}" @if (request('sesi') === $sesi->value) selected @endif>
                        {{ $sesi->label() }}</option>
                @endforeach
            </select>
            <input type="text" class="input" name="search" value="{{ request('search') }}"
                placeholder="Cari gelombang pelatihan" />
            <button class="btn btn-primary">
                <x-lucide-search class="w-4" />
            </button>
        </form>
        {{-- Action button --}}
        <div class="flex flex-row gap-4">
            <a href="{{ route('admin.gelombang-pelatihan.create') }}" class="btn btn-primary">Tambah sesi</a>
        </div>
    </div>

    {{-- Datatable --}}
    <div class="flex flex-col gap-4">
        <x-ui.table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama gelombang</th>
                    <th>Durasi pelatihan</th>
                    <th>Tanggal mulai</th>
                    <th>Tanggal selesai</th>
                    <th>Maksimal peserta</th>
                    <th>Sesi gelombang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($datas->isNotEmpty())
                    @foreach ($datas as $item)
                        <tr>
                            <th>{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</th>
                            <td>{{ $item->nama_gelombang }}</td>
                            <td>{{ $item->formatted_durasi_pelatihan }}</td>
                            <td>{{ $item->formatted_tanggal_mulai }}</td>
                            <td>{{ $item->formatted_tanggal_selesai }}</td>
                            <td>{{ $item->total_maksimal_peserta }}</td>
                            <td>{{ $item->sesi->label() }}</td>
                            <td>
                                <div class="flex flex-row gap-4">
                                    <a href="{{ route('admin.gelombang-pelatihan.show', [$item->id]) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                    <a href="{{ route('admin.gelombang-pelatihan.edit', [$item->id]) }}"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.gelombang-pelatihan.destroy', [$item->id]) }}"
                                        method="post"
                                        onsubmit="return confirm('Apakah anda yakin ingin menghapus {{ $item->nama_gelombang }} ?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-error">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            Data gelombang pelatihan tidak tersedia.
                        </td>
                    </tr>
                @endif
            </tbody>
        </x-ui.table>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>

</x-layouts.admin-app>
