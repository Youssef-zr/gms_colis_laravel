<?php
/**
 *
 */
namespace App\Traits;

use Illuminate\Support\Facades\File;

trait UploadFiles
{
    // store new file
    public static function storeFile($file, $storagePath)
    {
        $fileName = pathinfo($file, PATHINFO_FILENAME);

        $originalname = $file->getClientOriginalName();
        $file_name = date('Y-m-d') . "-" . $fileName . "-" . time() . "." . $file->getClientOriginalExtension();
        $path = $file->storeAs($storagePath, $file_name);

        $fileInformation = [
            'original_name' => $originalname,
            'file_name' => $file_name,
            'file_extension' => $file->extension(),
            'file_size' => $file->getSize(),
            'file_path' => $path,
        ];

        $file->move($storagePath, $file_name);

        return $fileInformation;
    }

    // update existing file
    public static function updateFile($file, $path, $oldFilePath, $default = null)
    {
        UploadFiles::removeFile($oldFilePath, $default);
        return UploadFiles::storeFile($file, $path);
    }

    // remove existing file
    public static function removeFile($oldFilePath, $default = null)
    {
        if (File::exists(public_path($oldFilePath)) and $default != "default.png") {
            @unlink(public_path($oldFilePath));
        }
    }

}
