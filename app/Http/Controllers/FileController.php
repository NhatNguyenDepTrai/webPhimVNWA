<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class FileController extends Controller
{
    public function ckediterUploadsImage(Request $request)
    {
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('PhotoNew');
            return response()->json(['url' => $path]);
        }
        return response()->json(['error' => 'No file provided'], 400);
    }
}
