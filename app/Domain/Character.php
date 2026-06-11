<?php

namespace App\Domain;

class Character {
    public ?int $id;
    public string $name;
    public ?string $epithet;
    public ?int $bounty;
    public ?string $devil_fruit;
    public ?string $photo_url;
    public ?string $general_information;
    public ?string $created_at;
    public ?string $updated_at;

    /** @var CharacterArc[] */
    public array $arcs = [];
    
    /** @var CharacterAbility[] */
    public array $abilities = [];

    public function __construct(
        string $name = '',
        ?string $epithet = null,
        ?int $bounty = null,
        ?string $devil_fruit = null,
        ?string $photo_url = null,
        ?string $general_information = null
    ) {
        $this->name = $name;
        $this->epithet = $epithet;
        $this->bounty = $bounty;
        $this->devil_fruit = $devil_fruit ?? 'None';
        $this->photo_url = $photo_url;
        $this->general_information = $general_information;
    }
}
