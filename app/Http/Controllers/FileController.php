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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $files = File::orderBy('created_at', 'DESC')
            ->with('author')
            ->paginate(20);
        $count = File::all()->count();
        return view('files.index', ['files' => $files, 'available' => $count]);
    }

    public function download($id) {
        $file = File::find($id);
        if ($file == null) {
            return redirect()->route('home')->with('error', __("Can't find the file."));
        }
        return response()
            ->download(public_path($file->path));
    }

    public function delete($id)
    {
        $file = File::find($id);
        if ($file == null) {
            return redirect()->route('home')->with('error', __("Can't find the file."));
        }
        Storage::delete(public_path($file->path));
        if ($file->delete()) {
            return redirect(route('home'))->with('success', __("The file was successfully removed."));
        }

        return redirect(route('home'))->with('error', __("Can't remove the file."));
    }
}
