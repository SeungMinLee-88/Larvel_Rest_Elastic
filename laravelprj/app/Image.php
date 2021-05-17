<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Imageget;
class Image extends Model
{
    public function __construct($directory = '/')
    {
        $this->directory = $directory;
    }

    public function image($file)
    {
        return Imageget::make($this->getPath($file));
    }
    private function getPath($file)
    {
        $path = base_path($this->directory . DIRECTORY_SEPARATOR . $file);

        if (! File::exists($path)) {
            abort(404, 'File not exist');
        }

        return $path;
    }

}
