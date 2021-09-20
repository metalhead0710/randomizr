<?php

namespace App\Models;

class PlaylistItems {

    protected $sets;

    protected $encore;

    public function __construct(array $sets, ?array $encore)
    {
        $this->sets = $sets;
        $this->encore = $encore;
    }

    public function getSets(): array {
        return $this->sets;
    }

    public function getEncore(): ?array {
        return $this->encore;
    }
}
