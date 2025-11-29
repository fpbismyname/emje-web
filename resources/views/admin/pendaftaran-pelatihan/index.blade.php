<x-layouts.admin-app title="Pendaftaran pelatihan">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="status" class="select">
                <option value="">Pilih status</option>
                @foreach (App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum::cases() as $status)
                    <option value="{{ $status->value }}" @if (request('status') === $status->value) selected @endif>
                        {{ $status->label() }}</option>
                @endforeach
            </select>
            <select name="skema_pembayaran" class="select">
                <option value="">Pilih skema pembayaran</option>
                @foreach (App\Enums\Pelatihan\SkemaPembayaranEnum::cases() as $status)
                    <option value="{{ $status->value }}" @if (request('skema_pembayaran') === $status->value) selected @endif>
                        {{ $status->label() }}</option>
                @endforeach
            </select>
            <input type="text" class="input" name="search" value="{{ request('search') }}"
                placeholder="Cari pendaftaran pelatihan" />
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
                    <th>Nama pelatihan</th>
                    <th>Nama peserta</th>
                    <th>Status</th>
                    <th>Skema pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($datas->isNotEmpty())
                    @foreach ($datas as $item)
                        <tr>
                            <th>{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</th>
                            <td>{{ $item->pelatihan_nama_pelatihan }}</td>
                            <td>{{ $item->users_profil_user_nama_lengkap }}</td>
                            <td>{{ $item->status->label() }}</td>
                            <td>{{ $item->skema_pembayaran->label() }}</td>
                            <td>
                                <div class="flex flex-row gap-4">
                                    <a href="{{ route('admin.pendaftaran-pelatihan.edit', [$item->id]) }}"
                                        class="btn btn-sm btn-primary">Periksa</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            Data pendaftaran pelatihan tidak tersedia.
                        </td>
                    </tr>
                @endif
            </tbody>
        </x-ui.table>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>

</x-layouts.admin-app>
