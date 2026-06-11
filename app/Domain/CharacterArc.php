<?php

namespace App\Domain;

class CharacterArc {
    public ?int $id;
    public ?int $character_id;
    public string $arc_name;
    public ?string $status;
    public ?string $arc_photo_url;

    public function __construct(string $arc_name, ?string $status = null, ?string $arc_photo_url = null) {
        $this->arc_name = $arc_name;
        $this->status = $status;
        $this->arc_photo_url = $arc_photo_url;
    }
}
