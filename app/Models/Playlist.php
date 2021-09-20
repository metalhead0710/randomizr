<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'file',
        'user',
        'content'
    ];

    public function author()
    {
        return $this->belongsTo(
            User::class,
            'user',
            'id'
        );
    }

    public function document()
    {
        return $this->hasOne(File::class, 'id', 'file');
    }

    public function getContent(): ?PlaylistItems {
        if (empty($this->content)) {
            return NULL;
        }

        return unserialize($this->content);
    }

    public function setContentAttribute(PlaylistItems $items) {
        $this->attributes['content'] = serialize($items);
    }

    public function setNameAttribute(?string $value) {
        if ($value !== NULL) {
            $this->attributes['name'] = $value;
            return;
        }
        $date = new \DateTime();
        $this->attributes['name'] = __("Outcry at :date.", ['date' => $date->format('d/m/Y')]);
    }

}
