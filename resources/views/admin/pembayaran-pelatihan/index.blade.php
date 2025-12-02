<x-layouts.admin-app title="Data pembayaran pelatihan">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="skema_pembayaran" class="select">
                <option value="">Pilih skema pembayaran</option>
                @foreach (App\Enums\Pelatihan\SkemaPembayaranEnum::cases() as $skema)
                    <option value="{{ $skema->value }}" @if (request('skema_pembayaran') === $skema->value) selected @endif>
                        {{ $skema->label() }}</option>
                @endforeach
            </select>
            <input type="text" class="input" name="search" value="{{ request('search') }}"
                placeholder="Cari pembayaran pelatihan" />
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
                    <th>Nama pelatihan</th>
                    <th>Nominal pembayaran</th>
                    <th>Skema pembayaran</th>
                    <th>Status pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($datas->isNotEmpty())
                    @foreach ($datas as $item)
                        <tr>
                            <th>{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</th>
                            <td>{{ $item->users->profil_user->nama_lengkap }}</td>
                            <td>{{ $item->pelatihan->nama_pelatihan }}</td>
                            <td>{{ $item->pelatihan->formatted_nominal_biaya }}</td>
                            <td>{{ $item->skema_pembayaran->label() }}</td>
                            <td>{{ $item->pembayaran_pelatihan_lunas ? 'Lunas' : 'Belum lunas' }}</td>
                            <td>
                                <div class="flex flex-row gap-4">
                                    <a href="{{ route('admin.pembayaran-pelatihan.show', [$item->id]) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            Data pembayaran pelatihan tidak tersedia.
                        </td>
                    </tr>
                @endif
            </tbody>
        </x-ui.table>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>

</x-layouts.admin-app>
