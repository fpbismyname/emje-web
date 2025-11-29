<x-layouts.admin-app>
    {{-- Header rekening saldo --}}
    <div class="stats stats-vertical md:stats-horizontal w-full">
        <!-- Saldo rekening -->
        <div class="stat bg-base-200">
            <div class="stat-title">Saldo rekening</div>
            <div class="stat-value text-primary">{{ $datas_rekening->formatted_saldo }}</div>
        </div>
        <!-- Pemasukan -->
        <div class="stat bg-base-200">
            <div class="stat-title">Pemasukan</div>
            <div class="stat-value text-success">{{ $datas_rekening->formatted_inflow_data }}</div>
        </div>
        <!-- Pengeluaran -->
        <div class="stat bg-base-200">
            <div class="stat-title">Pengeluaran</div>
            <div class="stat-value text-error">{{ $datas_rekening->formatted_outflow_data }}</div>
        </div>
    </div>

    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="tipe_transaksi" class="select">
                <option value="">Pilih tipe transaksi</option>
                @foreach (App\Enums\Rekening\TipeTransaksiEnum::cases() as $tipe_transaksi)
                    <option value="{{ $tipe_transaksi->value }}" @if (request('tipe_transaksi') === $tipe_transaksi->value) selected @endif>
                        {{ $tipe_transaksi->label() }}</option>
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
                    <th>Nominal Transaksi</th>
                    <th>Keterangan</th>
                    <th>Tipe Transaksi</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @if ($datas_transaksi->isNotEmpty())
                    @foreach ($datas_transaksi as $item)
                        <tr>
                            <th>{{ $loop->iteration + ($datas_transaksi->currentPage() - 1) * $datas_transaksi->perPage() }}
                            </th>
                            <td>{{ $item->formatted_nominal_transaksi }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>{{ $item->tipe_transaksi->label() }}</td>
                            <td>{{ $item->formatted_tanggal_transaksi }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            Data transaksi rekening tidak tersedia.
                        </td>
                    </tr>
                @endif
            </tbody>
        </x-ui.table>
        {{ $datas_transaksi->links('vendor.pagination.daisyui') }}
    </div>
</x-layouts.admin-app>
