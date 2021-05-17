<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class ImageController extends Controller
{
    protected $image;
    public function __construct(Image $image)
    {
        $this->image = $image;
    }
    public function image($file)
    {
        $image = $this->image->image($file);

        return response($image->encode('png'), 200, [
            'Content-Type'  => 'image/png'
        ]);
    }
}
