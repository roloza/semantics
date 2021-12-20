<?php


namespace App\Http\Controllers;


use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function displayImage($slug)
    {
        $image = Image::where('slug', $slug)->first();
        $path = Storage::disk('public')->path($image->filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;

    }
}