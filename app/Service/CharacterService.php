<?php

namespace App\Service;

use App\Domain\Character;
use App\Domain\CharacterArc;
use App\Domain\CharacterAbility;
use App\Repository\CharacterRepository;
use App\Exception\AppException;
use App\Config\App;

class CharacterService
{
    private CharacterRepository $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllCharacters(): array
    {
        return $this->repository->findAll();
    }

    public function getCharacterById(int $id): Character
    {
        $character = $this->repository->findById($id);
        if (!$character) {
            throw new AppException("Character not found.");
        }
        return $character;
    }

    public function createCharacter(array $data, array $files): void
    {
        $this->validateData($data);

        // Upload main photo
        $photoUrl = null;
        if (!empty($files['photo']['name'])) {
            $photoUrl = $this->uploadFile($files['photo'], 'character');
        }

        $character = new Character(
            $data['name'],
            $data['epithet'] ?? null,
            empty($data['bounty']) ? null : (int)$data['bounty'],
            $data['devil_fruit'] ?? null,
            $photoUrl,
            $data['general_information'] ?? null
        );

        $this->repository->beginTransaction();
        try {
            $charId = $this->repository->save($character);

            // Process Arcs
            $arcs = $this->processArcs($data['arcs'] ?? [], $files['arc_photos'] ?? []);
            if (!empty($arcs)) {
                $this->repository->saveArcs($charId, $arcs);
            }

            // Process Abilities
            $abilities = $this->processAbilities($data['abilities'] ?? [], $files['ability_photos'] ?? []);
            if (!empty($abilities)) {
                $this->repository->saveAbilities($charId, $abilities);
            }

            $this->repository->commit();
        } catch (\Exception $e) {
            $this->repository->rollBack();
            throw new AppException("Failed to save character: " . $e->getMessage());
        }
    }

    public function updateCharacter(int $id, array $data, array $files): void
    {
        $this->validateData($data);

        $existing = $this->getCharacterById($id);

        $photoUrl = $existing->photo_url;
        if (!empty($files['photo']['name'])) {
            $photoUrl = $this->uploadFile($files['photo'], 'character');
        }

        $character = new Character(
            $data['name'],
            $data['epithet'] ?? null,
            empty($data['bounty']) ? null : (int)$data['bounty'],
            $data['devil_fruit'] ?? null,
            $photoUrl,
            $data['general_information'] ?? null
        );
        $character->id = $id;

        $this->repository->beginTransaction();
        try {
            $this->repository->update($character);

            // Process Arcs (needs existing photos if new ones are not uploaded)
            // For simplicity in this demo, if no new photo uploaded, it might be lost unless handled carefully.
            // We'll pass the existing arcs to preserve photos if none uploaded.
            $arcs = $this->processArcs($data['arcs'] ?? [], $files['arc_photos'] ?? [], $existing->arcs);
            $this->repository->saveArcs($id, $arcs);

            // Process Abilities
            $abilities = $this->processAbilities($data['abilities'] ?? [], $files['ability_photos'] ?? [], $existing->abilities);
            $this->repository->saveAbilities($id, $abilities);

            $this->repository->commit();
        } catch (\Exception $e) {
            $this->repository->rollBack();
            throw new AppException("Failed to update character: " . $e->getMessage());
        }
    }

    public function deleteCharacter(int $id): void
    {
        // Ensure it exists
        $this->getCharacterById($id);

        if (!$this->repository->delete($id)) {
            throw new AppException("Failed to delete character.");
        }
    }

    private function validateData(array $data): void
    {
        if (empty($data['name'])) {
            throw new AppException("Character name is required.");
        }
        if (!empty($data['bounty']) && !is_numeric($data['bounty'])) {
            throw new AppException("Bounty must be a number.");
        }
    }

    private function uploadFile(array $file, string $type): string
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new AppException("Invalid file type. Only JPG and PNG are allowed.");
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '.' . $ext;
        $targetDir = App::getPublicUploadPath($type);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetPath = $targetDir . $filename;
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new AppException("Failed to upload image.");
        }

        // Return relative URL for web access
        if ($type === 'character') {
            return App::UPLOAD_DIR_CHARACTERS . $filename;
        } elseif ($type === 'arc') {
            return App::UPLOAD_DIR_ARCS . $filename;
        } else {
            return App::UPLOAD_DIR_ABILITIES . $filename;
        }
    }

    private function processArcs(array $postArcs, array $fileArcs, array $existingArcs = []): array
    {
        $arcs = [];
        foreach ($postArcs as $index => $arcData) {
            if (empty($arcData['name'])) continue;

            $photoUrl = null;
            // Check if file was uploaded for this specific arc index
            if (isset($fileArcs['name'][$index]) && !empty($fileArcs['name'][$index])) {
                $file = [
                    'name' => $fileArcs['name'][$index],
                    'type' => $fileArcs['type'][$index],
                    'tmp_name' => $fileArcs['tmp_name'][$index],
                    'error' => $fileArcs['error'][$index],
                    'size' => $fileArcs['size'][$index]
                ];
                $photoUrl = $this->uploadFile($file, 'arc');
            } else {
                // Keep existing photo if updating
                if (isset($existingArcs[$index])) {
                    $photoUrl = $existingArcs[$index]->arc_photo_url;
                }
            }

            $arcs[] = new CharacterArc($arcData['name'], $arcData['status'] ?? null, $photoUrl);
        }
        return $arcs;
    }

    private function processAbilities(array $postAbilities, array $fileAbilities, array $existingAbilities = []): array
    {
        $abilities = [];
        foreach ($postAbilities as $index => $abData) {
            if (empty($abData['name']) || empty($abData['type'])) continue;

            $photoUrl = null;
            if (isset($fileAbilities['name'][$index]) && !empty($fileAbilities['name'][$index])) {
                $file = [
                    'name' => $fileAbilities['name'][$index],
                    'type' => $fileAbilities['type'][$index],
                    'tmp_name' => $fileAbilities['tmp_name'][$index],
                    'error' => $fileAbilities['error'][$index],
                    'size' => $fileAbilities['size'][$index]
                ];
                $photoUrl = $this->uploadFile($file, 'ability');
            } else {
                if (isset($existingAbilities[$index])) {
                    $photoUrl = $existingAbilities[$index]->ability_photo_url;
                }
            }

            $abilities[] = new CharacterAbility($abData['name'], $abData['type'], $abData['description'] ?? null, $photoUrl);
        }
        return $abilities;
    }
}
