<x-layouts.admin-app title="Pelatihan peserta">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="pendidikan_terakhir" class="select">
                <option value="">Pilih pendidikan terakhir</option>
                @foreach (App\Enums\User\PendidikanTerakhirEnum::cases() as $pendidikan_terakhir)
                    <option value="{{ $pendidikan_terakhir->value }}" @if (request('pendidikan_terakhir') === $pendidikan_terakhir->value) selected @endif>
                        {{ $pendidikan_terakhir->label() }}</option>
                @endforeach
            </select>
            <select name="jenis_kelamin" class="select">
                <option value="">Pilih jenis kelamin</option>
                @foreach (App\Enums\User\JenisKelaminEnum::cases() as $jenis_kelamin)
                    <option value="{{ $jenis_kelamin->value }}" @if (request('jenis_kelamin') === $jenis_kelamin->value) selected @endif>
                        {{ $jenis_kelamin->label() }}</option>
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
        <x-ui.table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama peserta</th>
                    <th>Jenis kelamin</th>
                    <th>Pendidikan terakhir</th>
                    <th>Pelatihan diikuti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($datas->isNotEmpty())
                    @foreach ($datas as $item)
                        <tr>
                            <th>{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</th>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->jenis_kelamin->label() }}</td>
                            <td>{{ $item->formatted_pendidikan_terakhir }}</td>
                            <td>{{ $item->users->jumlah_pelatihan_diikuti }}</td>
                            <td>
                                <div class="flex flex-row gap-4">
                                    <a href="{{ route('admin.pelatihan-peserta.show', [$item->id]) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
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
