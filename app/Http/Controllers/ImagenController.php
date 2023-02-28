<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000);

        $iamgenPath = public_path('uploads/posts') . '/' . $nombreImagen;
        $imagenServidor->save($iamgenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
