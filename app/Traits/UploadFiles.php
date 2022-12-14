<?php
/**
 *
 */
namespace App\Traits;

use Illuminate\Support\Facades\File;

trait UploadFiles
{
    // store new file
    public static function storeFile($file, $storagePath, $customName = "")
    {
        $fileName = pathinfo($file, PATHINFO_FILENAME);

        $originalname = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();

        $file_name = date('Y-m-d') . "-" . $fileName . "-" . time();
        $file_name = $customName != "" ? $customName : $file_name;
        $file_name = $file_name . "." . $fileExtension;

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
    public static function updateFile($file, $path, $oldFilePath, $default = null, $customName = null)
    {
        UploadFiles::removeFile($oldFilePath, $default);

        return UploadFiles::storeFile($file, $path, $customName);
    }

    // remove existing file
    public static function removeFile($oldFilePath, $default = null)
    {
        if (File::exists(public_path($oldFilePath)) and $default != "default.png") {
            @unlink(public_path($oldFilePath));
        }
    }

    // store new file base64
    public static function storeFileBase64($file, $storagePath, $customName = "")
    {
        $image_parts = explode(";base64,", $file);
        $image_type = explode("image/", $image_parts[0])[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = $customName != "" ? $customName : uniqid();
        $file_name = $file_name . '.' . $image_type;
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
    public static function updateFileBase64($file, $storagePath, $oldFilePath, $customName = "")
    {
        UploadFiles::removeFile($oldFilePath);

        return UploadFiles::storeFileBase64($file, $storagePath, $customName);
    }

    // convert image to base 64
    public static function fileTo64bit($file)
    {
        $file_type = $file->extension();
        $base64 = "data:image/" . $file_type . ";base64," . base64_encode(file_get_contents($file));

        return $base64;
    }

    public function compressedImage($file, $name = null, $storage)
    {
        if (request()->hasFile($file)) {

            $_file = $_FILES[$file];
            $conver_image = $_FILES[$file]['tmp_name'];

            $extension = substr($_file['type'],6);

            $image = null;
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($conver_image);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($conver_image);
                    break;
                case 'png':
                    $image = @imagecreatefrompng($conver_image);
                    break;
            }

            $new_conver_image = $storage . "/" . $name;

            imagejpeg($image,$new_conver_image,25);
        }

    }

}
