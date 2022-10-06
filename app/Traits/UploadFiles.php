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

    // store new file base64
    public static function storeFileBase64($file, $storagePath)
    {
        $image_parts = explode(";base64,", $file);
        $image_type = explode("image/", $image_parts[0])[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = uniqid() . '.' . $image_type;
        $path = $storagePath . $file_name;

        file_put_contents(public_path($path), $image_base64);

        $fileInformation = [
            'file_name' => $file_name,
            'path' => $path,
            'file_extension' => $image_type,
        ];

        return $fileInformation;
    }

    // update existing file base64
    public static function updateFileBase64($file, $storagePath, $oldFilePath)
    {
        UploadFiles::removeFile($oldFilePath);
        return UploadFiles::storeFileBase64($file, $storagePath);
    }

    // convert image to base 64
    public static function fileTo64bit($file)
    {
        $file_type = $file->extension();
        $base64 = "data:image/" . $file_type . ";base64," . base64_encode(file_get_contents($file));

        return $base64;
    }

}
