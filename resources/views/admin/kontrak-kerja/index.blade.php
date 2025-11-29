<x-layouts.admin-app title="Daftar kontrak kerja">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="status" class="select">
                <option value="">Pilih status</option>
                @foreach (App\Enums\KontrakKerja\StatusKontrakKerjaEnum::cases() as $status)
                    <option value="{{ $status->value }}" @if (request('status') === $status->value) selected @endif>
                        {{ $status->label() }}</option>
                @endforeach
            </select>
            <input type="text" class="input" name="search" value="{{ request('search') }}"
                placeholder="Cari daftar kontrak kerja" />
            <button class="btn btn-primary">
                <x-lucide-search class="w-4" />
            </button>
        </form>
        {{-- Action button --}}
        <div class="flex flex-row gap-4">
            <a href="{{ route('admin.kontrak-kerja.create') }}" class="btn btn-primary">Tambah kontrak kerja</a>
        </div>
    </div>

    {{-- Datatable --}}
    <div class="flex flex-col gap-4">
        <x-ui.table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Perusahaan</th>
                    <th>Gaji</th>
                    <th>Status</th>
                    <th>Durasi kontrak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($datas->isNotEmpty())
                    @foreach ($datas as $item)
                        <tr>
                            <th>{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</th>
                            <td>{{ $item->formatted_nama_perusahaan }}</td>
                            <td>{{ $item->formatted_rentang_gaji }}</td>
                            <td>{{ $item->status->label() }}</td>
                            <td>{{ $item->formatted_durasi_kontrak_kerja }}</td>
                            <td>
                                <div class="flex flex-row gap-4">
                                    <a href="{{ route('admin.kontrak-kerja.show', [$item->id]) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                    <a href="{{ route('admin.kontrak-kerja.edit', [$item->id]) }}"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.kontrak-kerja.destroy', [$item->id]) }}"
                                        method="post"
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
                            Data kontrak kerja tidak tersedia.
                        </td>
                    </tr>
                @endif
            </tbody>
        </x-ui.table>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>

</x-layouts.admin-app>
