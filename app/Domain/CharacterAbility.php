<?php

namespace App\Domain;

class CharacterAbility {
    public ?int $id;
    public ?int $character_id;
    public string $ability_name;
    public string $ability_type;
    public ?string $description;
    public ?string $ability_photo_url;

    public function __construct(string $ability_name, string $ability_type, ?string $description = null, ?string $ability_photo_url = null) {
        $this->ability_name = $ability_name;
        $this->ability_type = $ability_type;
        $this->description = $description;
        $this->ability_photo_url = $ability_photo_url;
    }
}
