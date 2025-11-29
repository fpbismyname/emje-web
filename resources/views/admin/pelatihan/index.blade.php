<x-layouts.admin-app title="Daftar pelatihan">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="status" class="select">
                <option value="">Pilih status</option>
                @foreach (App\Enums\Pelatihan\StatusPelatihanEnum::cases() as $status)
                    <option value="{{ $status->value }}" @if (request('status') === $status->value) selected @endif>
                        {{ $status->label() }}</option>
                @endforeach
            </select>
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
        {{-- Action button --}}
        <div class="flex flex-row gap-4">
            <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-primary">Tambah pelatihan</a>
        </div>
    </div>

    {{-- Datatable --}}
    <div class="flex flex-col gap-4">
        <x-ui.table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama pelatihan</th>
                    <th>Nominal biaya</th>
                    <th>Kategori pelatihan</th>
                    <th>Status</th>
                    <th>Durasi pelatihan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($datas->isNotEmpty())
                    @foreach ($datas as $item)
                        <tr>
                            <th>{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</th>
                            <td>{{ $item->formatted_nama_pelatihan }}</td>
                            <td>{{ $item->formatted_nominal_biaya }}</td>
                            <td>{{ $item->kategori_pelatihan->label() }}</td>
                            <td>{{ $item->status->label() }}</td>
                            <td>{{ $item->formatted_durasi_pelatihan }}</td>
                            <td>
                                <div class="flex flex-row gap-4">
                                    <a href="{{ route('admin.pelatihan.show', [$item->id]) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                    <a href="{{ route('admin.pelatihan.edit', [$item->id]) }}"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.pelatihan.destroy', [$item->id]) }}" method="post"
                                        onsubmit="return confirm('Apakah anda yakin ingin menghapus {{ $item->nama_perusahaan }} ?')">
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
                            Data pelatihan tidak tersedia.
                        </td>
                    </tr>
                @endif
            </tbody>
        </x-ui.table>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>

</x-layouts.admin-app>
