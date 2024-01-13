<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManager
{
    static function upload($file, string $storage_path, string $fileName = null, string $extension = null)
    {
        $fileName = ($fileName ?? Str::uuid()) . $extension;
        return Storage::put("data" . $storage_path, $file, $fileName);
    }

    static function remove(string $filePath)
    {
        if (Storage::exists(storage_path($filePath))) {
            Storage::delete(storage_path($filePath));
        }
    }
}
