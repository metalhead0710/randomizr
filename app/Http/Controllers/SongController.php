<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
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
     * .
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $songs = Song::orderBy('created_at', 'DESC')->paginate(20);
        $count = Song::all()->count();
        return view('songs.index', ['songs' => $songs, 'available' => $count]);
    }

    public function addForm()
    {
        return view('songs.add');
    }

    public function editForm($id)
    {
        $song = Song::find($id);
        if ($song == null) {
            return redirect()->route('songs')->with('error', __("Can't find the song."));
        }

        return view('songs.update', ['song' => $song]);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'author' => 'required|max:255',
            'name' => 'required|max:255',
        ]);
        if (
        Song::create([
            'author' => $request->input('author'),
            'name' => $request->input('name'),
            'tempo' => $request->input('tempo'),
        ])
        ) {
            return redirect()
                ->route('songs')->with('success', __('Song was successfully saved.'));
        }

        return redirect()->back()->with('error', __('Something went wrong.'));
    }

    public function patch(Request $request, $id)
    {
        $song = Song::find($id);
        if ($song == null) {
            return redirect()->route('songs')->with('error', __("Can't find the song."));
        }
        $this->validate($request, [
            'author' => 'required|max:255',
            'name' => 'required|max:255',
        ]);

        $song->author = $request->input('author');
        $song->name = $request->input('name');
        $song->tempo = $request->input('tempo');
        if ($song->save()) {
            return redirect()->route('songs')->with('success', __('Song was succesfully updated.'));
        }

        return redirect()->back()->with('error', __('Something went wrong.'));
    }

    public function delete($id)
    {
        $song = Song::find($id);
        if ($song == null) {
            return redirect()->route('songs')->with('error', __("Can't find the song."));
        }
        if ($song->delete()) {
            return redirect(route('songs'))->with('success', __("The song was successfully removed."));
        }

        return redirect(route('songs'))->with('error', __("Can't remove the song."));
    }
}
