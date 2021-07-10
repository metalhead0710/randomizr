<?php

namespace App\Services;

use App\Models\File;
use App\Models\Song;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class PlayListDocumentBuilder
{
    /**
     * Contains playlist song collection.
     *
     * @var array
     */
    private $playListSongs;

    /**
     * Contains encore song collection.
     *
     * @var array
     */
    private $encoreSongs;

    public function __construct(
        array $playListSongs,
        Collection $encoreSongs = NULL
    ) {
        $this->playListSongs = $playListSongs;
        $this->encoreSongs = $encoreSongs;
    }

    public function createFile(): File {
        $now = new \DateTime();
        $documentName = "OutCryPlaylist_{$now->format('d-m-Y_His')}.docx";
        $path = "playlists/{$documentName}";
        $document = $this->formDocument();
        $objWriter = IOFactory::createWriter($document, 'Word2007');
        $objWriter->save(public_path($path));
        $file = File::create([
            'name' => $documentName,
            'path' => $path,
            'user' => Auth::id(),
        ]);

        return $file;
    }

    protected function formDocument(): PhpWord {
        $document = new PhpWord();
        $section = $document->addSection();
        $section->addText(
            __('Outcry playlist'),
            ['name' => 'Arial', 'size' => 18, 'bold' => TRUE]
        );
        foreach ($this->playListSongs as $setKey => $collection) {
            $setNum = $setKey + 1;
            $section->addText("Set #$setNum", ['name' => 'Arial', 'size' => 16, 'bold' => TRUE]);
            foreach ($collection as $i => $song) {
                $songRow = $this->createSongRow($song, $i);
                $section->addText($songRow, ['name' => 'Arial', 'size' => 14]);
            }
        }
        if (!empty($this->encoreSongs)) {
            $section->addText(__('Encore songs'), ['name' => 'Arial', 'size' => 16, 'bold' => TRUE]);
            foreach ($this->encoreSongs as $i => $song) {
                $songRow = $this->createSongRow($song, $i);
                $section->addText($songRow, ['name' => 'Arial', 'size' => 14]);
            }
        }

        return $document;
    }

    protected function createSongRow(Song $song, int $i): string {
        $songNumber = $i + 1;
        $tempo = isset($song->tempo) ? "#{$song->tempo}" : '';
        return "{$songNumber}. {$song->author} - {$song->name} $tempo";
    }

}
