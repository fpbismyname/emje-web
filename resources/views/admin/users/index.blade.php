<x-layouts.admin-app title="Data akun pengguna">
    {{-- Header --}}
    <div class="flex flex-row justify-between gap-4 flex-wrap">
        {{-- Filter & Search --}}
        <form method="get" class="flex flex-row md:flex-1 gap-4 flex-wrap">
            <select name="role" class="select">
                <option value="">Pilih role</option>
                @foreach (App\Enums\User\RoleEnum::cases() as $role)
                    <option value="{{ $role->value }}" @if (request('role') === $role->value) selected @endif>
                        {{ $role->label() }}</option>
                @endforeach
            </select>
            <input type="text" class="input" name="search" value="{{ request('search') }}"
                placeholder="Cari peserta" />
            <button class="btn btn-primary">
                <x-lucide-search class="w-4" />
            </button>
        </form>
        {{-- Action button --}}
        <div class="flex flex-row gap-4">
            <div class="dropdown dropdown-bottom md:dropdown-end">
                <div tabindex="0" role="button" class="btn btn-primary">
                    Tambah akun
                </div>
                <ul class="dropdown-content menu bg-base-100 shadow-md rounded-box w-32">
                    <li><a href="{{ route('admin.users.client_create') }}">Akun client</a></li>
                    <li><a href="{{ route('admin.users.admin_create') }}">Akun admin</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Datatable --}}
    <div class="flex flex-col gap-4">
        <x-ui.table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($datas->isNotEmpty())
                    @foreach ($datas as $item)
                        <tr>
                            <th>{{ $loop->iteration + ($datas->currentPage() - 1) * $datas->perPage() }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->role->label() }}</td>
                            <td>
                                <div class="flex flex-row gap-4">
                                    <a href="{{ route('admin.users.show', [$item->id]) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                    <a href="{{ route('admin.users.edit', [$item->id]) }}"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.users.destroy', [$item->id]) }}" method="post"
                                        onsubmit="return confirm('Apakah anda yakin ingin menghapus {{ $item->name }} ?')">
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
                            Data user tidak tersedia.
                        </td>
                    </tr>
                @endif
            </tbody>
        </x-ui.table>
        {{ $datas->links('vendor.pagination.daisyui') }}
    </div>

</x-layouts.admin-app>
