<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Playlist;
use App\Models\PlaylistItems;
use App\Models\Song;
use App\Services\PlayListDocumentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
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
        $playlists = Playlist::orderBy('created_at', 'DESC')
            ->with(['author', 'document'])
            ->paginate(20);
        $count = Playlist::all()->count();
        return view('playlists.index', ['playlists' => $playlists, 'available' => $count]);
    }

    public function editForm(int $id) {
        $playlist = Playlist::find($id);
        if ($playlist == null) {
            return redirect()->route('songs')->with('error', __("Can't find the playlist."));
        }
        $songData = $this->buildPlaylist($playlist);

        return view('playlist.randomized',['playlist' => $playlist, 'data' => $songData]);
    }

    protected function buildPlayList(Playlist $playlist): array {
        $result = [
            'sets' => [],
            'encore' => [],
            'unused' => [],
        ];
        $playlistContent = $playlist->getContent();
        $sets = $playlistContent->getSets();
        $encore = $playlistContent->getEncore();
        $usedSongIds = [];
        foreach ($sets as $delta => $set) {
            $usedSongIds = array_merge($usedSongIds, $set);
            $setIds = implode(', ', $set);
            $songs = Song::whereIn('id', $set)
                ->orderByRaw("FIELD(id, {$setIds})")
                ->get();
            $result['sets'][$delta] = $songs;
        }
        if ($encore) {
            $usedSongIds = array_merge($usedSongIds, $encore);
            $encoreIds = implode(', ', $encore);
            $result['encore'] = Song::whereIn('id', $encore)
                ->orderByRaw("FIELD(id, {$encoreIds})")
                ->get();
        }
        if (!empty($usedSongIds)) {
            $unusedSongs = Song::whereNotIn('id', $usedSongIds)
                ->get();
            $result['unused'] = $unusedSongs;
        }

        return $result;
    }

    public function save(Request $request) {
        $sets = $request->input('set');
        $encore = $request->input('encore');
        switch ($request->input('action')) {
            case 'save':
                $id = $request->input('id');
                $name = $request->input('name');
                return $this->savePlaylist($id, $name, $sets, $encore);

            case 'export':
                $file = $this->generateFile($sets, $encore);
                return response()
                    ->download(public_path($file->path));
        }
    }

    public function delete($id)
    {
        $playlist = Playlist::find($id);
        if ($playlist == null) {
            return redirect()->route('home')->with('error', __("Can't find the playlist."));
        }
        $this->deleteFile($playlist->file);
        if ($playlist->delete()) {
            return redirect(route('home'))->with('success', __("The playlist was successfully removed."));
        }

        return redirect(route('home'))->with('error', __("Can't remove the playlist."));
    }

    public function deleteFile($id)
    {
        $file = File::find($id);
        if ($file == null) {
            return redirect()->route('home')->with('error', __("Can't find the file."));
        }
        Storage::delete(public_path($file->path));
        if (!$file->delete()) {
            return redirect(route('home'))->with('error', __("Can't remove the file."));
        }
    }

    protected function savePlaylist(?int $id, ?string $name, array $sets, ?array $encore) {
        if ($sets === NULL) {
            return redirect()->back()->with('error', __('Try to drag & drop songs.'));
        }
        $file = $this->generateFile($sets, $encore);

        $playList = $this->updateOrCreatePlaylist($id, $name, $sets, $encore, $file);

        if ($playList) {
            return redirect()
                ->route('home')->with('success', __('Playlist was successfully saved.'));
        }
        return redirect()->back()->with('error', __('Something went wrong. Try again later.'));
    }

    protected function updateOrCreatePlaylist(?int $id, ?string $name, array $sets, ?array $encore, File $file) {
        if ($id === NULL) {
            return Playlist::create([
                'name' => $name,
                'file' => $file->id,
                'user' => Auth::id(),
                'content' => new PlaylistItems($sets, $encore),
            ]);
        }
        $playlist = Playlist::findOrFail($id);
        $playlist->name = $name;
        $playlist->file = $file->id;
        $playlist->user = Auth::id();
        $playlist->content = new PlaylistItems($sets, $encore);
        return $playlist->save();
    }

    protected function generateFile(array $sets, ?array $encore): ?File {
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
        return $documentBuilder->createFile();
    }
}
