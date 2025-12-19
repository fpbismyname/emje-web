<x-layouts.admin-app title="Data pembayaran dana talang">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="sumber_dana" class="select">
                <option value="">Pilih sumber dana</option>
                @foreach (App\Enums\KontrakKerja\SumberDanaEnum::cases() as $sumber)
                    <option value="{{ $sumber->value }}" @if (request('sumber_dana') === $sumber->value) selected @endif>
                        {{ $sumber->label() }}</option>
                @endforeach
            </select>
            <input type="text" class="input" name="search" value="{{ request('search') }}"
                placeholder="Cari pembayaran pelatihan" />
            <button class="btn btn-primary">
                <x-lucide-search class="w-4" />
            </button>
        </form>
        <div class="flex flex-row">
            <a href="{{ route('admin.export.pembayaran_dana_talang', ['search' => request('search'), 'sumber_dana' => request('sumber_dana')]) }}"
                class="btn btn-primary">Export data</a>
        </div>
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
                    <th>Sumber dana pemberangkatan</th>
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
                            <td>{{ $item->kontrak_kerja->nama_perusahaan }}</td>
                            <td>{{ config('rules-lpk.formatted_biaya_pemberangkatan') }}</td>
                            <td>{{ $item->sumber_dana->label() }}</td>
                            <td>{{ $item->pembayaran_kontrak_kerja_lunas ? 'Lunas' : 'Belum lunas' }}</td>
                            <td>
                                <div class="flex flex-row gap-4">
                                    <a href="{{ route('admin.pembayaran-dana-talang.show', [$item->id]) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            Data pembayaran dana talang tidak tersedia.
                        </td>
                    </tr>
                @endif
            </tbody>
        </x-ui.table>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>

</x-layouts.admin-app>
