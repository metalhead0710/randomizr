<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Services\PlayListDocumentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaylistGeneratorController extends Controller
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
    public function playlistLayout() {
        return view('playlist.layout');
    }

    public function randomize(Request $request) {
        $this->validate($request, [
            'sets' => 'required|integer|between:1,5',
            'per_set' => 'required|integer|between:1,20',
        ]);
        $songs = Song::orderByRaw('RAND()')->get();

        $songData = $this->structureData(
            $songs,
            $request->input('sets'),
            $request->input('per_set'),
            $request->input('encore') ?? FALSE
        );

        return view('playlist.randomized',['data' => $songData]);
    }

    public function export(Request $request) {
        $sets = $request->input('set');
        $encore = $request->input('encore');
        if ($sets === NULL) {
            return redirect()->back()->with('error', __('Try to drag & drop songs.'));
        }

        $playListSongs = [];
        $encoreSongs = NULL;
        foreach ($sets as $set) {
            $setIds = implode(', ', $set);
            $songs = Song::whereIn('id', $set)
                ->orderByRaw("FIELD(id, {$setIds})")
                ->get();
            $playListSongs[] = $songs;
        }
        if ($encore) {
            $encoreIds = implode(', ', $encore);
            $encoreSongs = Song::whereIn('id', $encore)
                ->orderByRaw("FIELD(id, {$encoreIds})")
                ->get();
        }

        $documentBuilder = new PlayListDocumentBuilder($playListSongs, $encoreSongs);
        $file = $documentBuilder->createFile();

        return response()
            ->download(public_path($file->path));
    }

    private function structureData(
        Collection $songs,
        int $setCount,
        int $perSet,
        bool $encore = FALSE
    ): array {
        $result = [];
        $offset = 0;
        for ($sets = 0; $sets < $setCount; $sets++) {
            $result['sets'][] = $songs->slice($offset, $perSet);
            $offset += $perSet;
        }
        if ($encore) {
            $encoreSongs = $songs->slice($offset, 2);
            $offset += 2;
            $result['encore'] = $encoreSongs;
        }
        $result['unused'] = $songs->slice($offset);

        return $result;
    }
}
