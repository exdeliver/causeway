<?php

namespace Exdeliver\Causeway\Domain\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Class UploadService
 * @package Domain\Services
 */
class UploadService extends AbstractService
{
    /**
     * @var array
     */
    public $imageSizes = ['180', '360', '720', '960'];

    /**
     * @var
     */
    public $uploadPhotoPath;

    /**
     * UploadService constructor.
     */
    public function __construct()
    {
        $uploadPaths = [];

        $this->uploadPhotoPath = config('panda.photo_uploads', 'public/uploads/photos');

        $uploadPaths[] = $this->uploadPhotoPath;

        foreach ($this->imageSizes as $imageSize) {
            $uploadPaths[] = $this->uploadPhotoPath . '/' . $imageSize;
        }

        $this->checkExistingFolders($uploadPaths);
    }

    /**
     * Check if paths exists and create if non existing.
     *
     * @param array $paths
     */
    protected function checkExistingFolders(array $paths): void
    {
        foreach ($paths as $path) {
            $path = str_replace(storage_path(), '', $path);

            $path = storage_path('app' . $path);

            if (File::exists($path) !== true) {
                File::makeDirectory($path, 0777, true);
            }
        }
    }

    /**
     * Upload file.
     *
     * @param $file
     * @param $path
     * @return \stdClass
     */
    public function upload(UploadedFile $file, $path = ''): \stdClass
    {
        // Set relative path.
        $fullFileName = $file->store($path);

        $fileName = ltrim(str_replace($path, '', '/' . $fullFileName), '/');

        $uploadObject = new \stdClass();
        $uploadObject->name = str_replace($path, '', $file->getClientOriginalName());
        $uploadObject->file_path = str_replace('public/', '', $fullFileName);
        $uploadObject->filename = $fileName;
        $uploadObject->size = round(Storage::size($fullFileName) / 1024, 2);

        return $uploadObject;
    }

    /**
     * @param $image
     * @param $name
     * @throws \Exception
     */
    public function resizeImage($image, $name)
    {
        // create instance
        $image = storage_path('app/public/' . $image);

        if (!File::exists($image)) {
            throw new \Exception('File not found');
        }

        $img = Image::make($image);

        $path = str_replace($name, '', $image);

        foreach ($this->imageSizes as $imageSize) {
            if (!is_dir($path . $imageSize)) {
                File::makeDirectory($path . $imageSize, 0777, true);
            }
            $img->resize($imageSize, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $imageSize . '/' . $name);
        }
    }
}