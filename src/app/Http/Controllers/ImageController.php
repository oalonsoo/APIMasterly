<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return response()->json(['data' => $images]);
    }

    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'path' => 'required|string|max:255',
        //     'main' => 'required|boolean',
        // ]);

        if ($request['image']) {
            $imagePath = $this->storeImage($request['image']);
        } else {
            $imagePath = $request['path'];
        }

        $image = Image::create([
            'path' => $imagePath,
            'main' => $request['main'],
            'product_id' =>  $request['product_id']
        ]);

        return response()->json([
            'message' => 'Image created successfully',
            'data' => $image
        ], 201);
    }

    private function storeImage($image)
    {
        $decodedImage = base64_decode($image);

        $fileName = Str::uuid()->toString() . '.png';

        Storage::put('public/images/' . $fileName, $decodedImage);

        return url('storage/images/' . $fileName);
    }

    public function showByProductId($id)
    {
        $images = Image::where('product_id', $id)->get();

        return response()->json([
            'data' => $images
        ]);
    }

    public function showByImageId($id)
    {
        $images = Image::where('id', $id)->get();

        return response()->json([
            'data' => $images
        ]);
    }

    public function deleteByImageId($id)
    {
        $image = Image::find($id);

        if ($image->isEmpty()) {
            return response()->json([
                'message' => 'No image found for image ID ' . $id
            ], 404);
        }

        $image->delete();

        return response()->json([
            'message' => 'Image deleted successfully'
        ]);
    }

    public function deleteByProductId($id)
    {
        $images = Image::where('product_id', $id)->get();

        if ($images->isEmpty()) {
            return response()->json([
                'message' => 'No images found for product ID ' . $id
            ], 404);
        }

        foreach ($images as $image) {
            $image->delete();
        }

        return response()->json([
            'message' => 'All images for product ID ' . $id . ' deleted successfully'
        ]);
    }
}
