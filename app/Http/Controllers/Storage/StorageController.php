<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function public_show(Request $request)
    {
        $file_path = $request->get(key: 'file');

        $public_storage = Storage::disk('public');

        if (!$public_storage->exists($file_path)) {
            abort(404);
        }

        $file = $public_storage->path($file_path);
        return response()->file($file);
    }

    public function public_download(Request $request)
    {
        $file_path = $request->get(key: 'file');

        $public_storage = Storage::disk('public');

        if (!$public_storage->exists($file_path)) {
            abort(404);
        }

        $file = $public_storage->path($file_path);
        return response()->download($file);
    }
    public function private_show(Request $request)
    {
        $file_path = $request->get(key: 'file');

        $public_storage = Storage::disk('local');

        if (!$public_storage->exists($file_path)) {
            abort(404);
        }

        $file = $public_storage->path($file_path);
        return response()->file($file);
    }

    public function private_download(Request $request)
    {
        $file_path = $request->get(key: 'file');

        $public_storage = Storage::disk('local');

        if (!$public_storage->exists($file_path)) {
            abort(404);
        }

        $file = $public_storage->path($file_path);
        return response()->download($file);
    }
}
