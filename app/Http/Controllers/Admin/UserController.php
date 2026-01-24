<?php

namespace App\Http\Controllers\Admin;

use App\Enums\User\RoleEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\ProfilUser;
use App\Models\User;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $relations = ['profil_user'];
    public function index(Request $request, User $user_model)
    {
        $filters = $request->only('search', 'role');

        $query = $user_model->with($this->relations);

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.users.index', $payload);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function client_create()
    {
        return view('admin.users.client-create');
    }
    public function admin_create()
    {
        return view('admin.users.admin-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request, User $user_model, ProfilUser $profil_user_model)
    {
        $request->validated();

        // Setup datafor update
        $data_user = $request->only($user_model->getFillable());
        $data_profil_user = $request->only($profil_user_model->getFillable());


        $user = $user_model->create($data_user);

        if (!empty($data_profil_user)) {

            // Upload files
            $uploadedFiles = [
                'ktp' => $request->file('ktp'),
                'foto_profil' => $request->file('foto_profil'),
                'ijazah' => $request->file('ijazah'),
            ];

            $private_storage = Storage::disk('local');

            $path_uploaded_file = [];

            foreach ($uploadedFiles as $key => $file) {
                if ($file) {

                    $ext = $file->getClientOriginalExtension();
                    $safeName = Str::slug($user->name);

                    $fileName = "{$user->id}_{$safeName}_{$key}." . $ext;

                    $path_uploaded_file[$key] = $private_storage->putFileAs("users/{$key}", $file, $fileName);
                }
            }

            // set path
            foreach ($path_uploaded_file as $key => $value) {
                $data_profil_user[$key] = $value;
            }

            $user->profil_user()->create($data_profil_user);
        }

        if ($user->wasRecentlyCreated) {
            Toast::success("Data akun pengguna {$user->name} berhasil ditambahkan.");
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, User $user_model)
    {
        $user = $user_model->findOrFail($id);
        $payload = compact('user');
        return view('admin.users.show', $payload);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, User $user_model)
    {
        $user = $user_model->findOrFail($id);
        $payload = compact('user');
        return view('admin.users.edit', $payload);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id, User $user_model, ProfilUser $profil_user_model)
    {
        $update_entries = $request->validated();

        $is_reset_password = isset($update_entries['reset_password']) ? $update_entries['reset_password'] == 'on' : false;

        $user = $user_model->findOrFail($id);

        if ($is_reset_password) {
            if (empty($update_entries['old_password'])) {
                Toast::error('Password lama wajib diisi.');
                return redirect()->back();
            }
            if (!Hash::check($update_entries['old_password'], $user->password)) {
                Toast::error('Password lama salah.');
                return redirect()->back();

            }
            $user->password = Hash::make($update_entries['new_password']);
            $user->save();
            if (auth()->user()->name === $update_entries['name']) {
                $request->session()->invalidate();
            }
        }

        // Setup datafor update
        $data_user = $request->only($user_model->getFillable());
        $data_profil_user = $request->only($profil_user_model->getFillable());

        // Upload files
        $uploadedFiles = [
            'ktp' => $request->file('ktp'),
            'foto_profil' => $request->file('foto_profil'),
            'ijazah' => $request->file('ijazah'),
        ];

        $private_storage = Storage::disk('local');

        $path_uploaded_file = [];

        foreach ($uploadedFiles as $key => $file) {
            if ($file) {
                $current_file_path = $user->profil_user->{$key};
                if ($current_file_path && $private_storage->exists($user->profil_user->{$key})) {
                    $private_storage->delete($user->profil_user->{$key});
                }
                $ext = $file->getClientOriginalExtension();
                $safeName = Str::slug($user->name);

                $fileName = "{$user->id}_{$safeName}_{$key}." . $ext;

                $path_uploaded_file[$key] = $private_storage->putFileAs("users/{$key}", $file, $fileName);
            }
        }

        // set path
        foreach ($path_uploaded_file as $key => $value) {
            $data_profil_user[$key] = $value;
        }

        $updated_user = $user->update($data_user);
        $updated_user_profil = $user->profil_user->update($data_profil_user);

        if ($updated_user || $updated_user_profil) {
            Toast::success("Data akun pengguna {$user->name} berhasil diperbarui.");
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, User $user_model)
    {
        $user = $user_model->findOrFail($id);

        $files_user = $user->profil_user->only(['ktp', 'ijazah', 'foto_profil']);

        $private_storage = Storage::disk('local');

        foreach ($files_user as $key => $value) {
            if ($private_storage->exists($value)) {
                $private_storage->delete($value);
            }
        }

        $deleted_user = $user->delete();

        if ($deleted_user) {
            Toast::success("Data akun pengguna {$user->name} berhasil dihapus.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->back();
    }
}
