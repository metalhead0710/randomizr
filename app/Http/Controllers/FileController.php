<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function download($id) {
        $file = File::find($id);
        if ($file == null) {
            return redirect()->route('home')->with('error', __("Can't find the file."));
        }
        return response()
            ->download(public_path($file->path));
    }

}
