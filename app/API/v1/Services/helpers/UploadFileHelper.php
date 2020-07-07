<?php


namespace App\API\v1\Services\helpers;

class UploadFileHelper
{
    private $_directory;

    function __construct($uploadImageDirectory)
    {
        $this->_directory = $uploadImageDirectory;
    }

    public function uploadFile($file, $groupName)
    {
        $stripName = str_replace(' ', '_', $groupName);
        $fileName = strtolower($stripName) . '-' . $this->_directory . '-photo-' . time() . '.' . $file->extension();
        $directory = "images/" . $this->_directory . "/";
        $status = $file->move(public_path($directory), $fileName);

        $directoryFileName = $directory . $fileName;
        if (!$status) {
            throw new \Exception("Unable to save photo", 500);
        }
        return $directoryFileName;
    }

    public function getFile($file)
    {
        return asset($file);
    }
}
