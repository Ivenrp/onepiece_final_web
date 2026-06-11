<?php

namespace App\Repository;

use App\Domain\Character;
use App\Domain\CharacterArc;
use App\Domain\CharacterAbility;
use PDO;

class CharacterRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function beginTransaction() { $this->db->beginTransaction(); }
    public function commit() { $this->db->commit(); }
    public function rollBack() { $this->db->rollBack(); }

    public function findAll(): array {
        $query = "SELECT * FROM characters ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $characters = [];
        while ($row = $stmt->fetch()) {
            $characters[] = $this->mapRowToCharacter($row);
        }
        return $characters;
    }

    public function findById(int $id): ?Character {
        $query = "SELECT * FROM characters WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            $character = $this->mapRowToCharacter($row);
            
            // Load Arcs
            $arcQuery = "SELECT * FROM character_arcs WHERE character_id = :id";
            $arcStmt = $this->db->prepare($arcQuery);
            $arcStmt->bindParam(':id', $id);
            $arcStmt->execute();
            while ($arcRow = $arcStmt->fetch()) {
                $arc = new CharacterArc($arcRow['arc_name'], $arcRow['status'], $arcRow['arc_photo_url']);
                $arc->id = $arcRow['id'];
                $arc->character_id = $arcRow['character_id'];
                $character->arcs[] = $arc;
            }

            // Load Abilities
            $abilityQuery = "SELECT * FROM character_abilities WHERE character_id = :id";
            $abilityStmt = $this->db->prepare($abilityQuery);
            $abilityStmt->bindParam(':id', $id);
            $abilityStmt->execute();
            while ($abRow = $abilityStmt->fetch()) {
                $ability = new CharacterAbility($abRow['ability_name'], $abRow['ability_type'], $abRow['description'], $abRow['ability_photo_url']);
                $ability->id = $abRow['id'];
                $ability->character_id = $abRow['character_id'];
                $character->abilities[] = $ability;
            }

            return $character;
        }
        return null;
    }

    public function save(Character $character): int {
        $query = "INSERT INTO characters (name, epithet, bounty, devil_fruit, photo_url, general_information) 
                  VALUES (:name, :epithet, :bounty, :devil_fruit, :photo_url, :general_information)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':name', $character->name);
        $stmt->bindParam(':epithet', $character->epithet);
        $stmt->bindParam(':bounty', $character->bounty);
        $stmt->bindParam(':devil_fruit', $character->devil_fruit);
        $stmt->bindParam(':photo_url', $character->photo_url);
        $stmt->bindParam(':general_information', $character->general_information);

        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    public function update(Character $character): bool {
        $query = "UPDATE characters 
                  SET name = :name, epithet = :epithet, bounty = :bounty, 
                      devil_fruit = :devil_fruit, photo_url = :photo_url, general_information = :general_information
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':name', $character->name);
        $stmt->bindParam(':epithet', $character->epithet);
        $stmt->bindParam(':bounty', $character->bounty);
        $stmt->bindParam(':devil_fruit', $character->devil_fruit);
        $stmt->bindParam(':photo_url', $character->photo_url);
        $stmt->bindParam(':general_information', $character->general_information);
        $stmt->bindParam(':id', $character->id);

        return $stmt->execute();
    }

    public function saveArcs(int $charId, array $arcs): void {
        // Delete old arcs first
        $delQuery = "DELETE FROM character_arcs WHERE character_id = :id";
        $delStmt = $this->db->prepare($delQuery);
        $delStmt->bindParam(':id', $charId);
        $delStmt->execute();

        // Insert new arcs
        $query = "INSERT INTO character_arcs (character_id, arc_name, status, arc_photo_url) VALUES (:character_id, :arc_name, :status, :arc_photo_url)";
        $stmt = $this->db->prepare($query);
        
        foreach ($arcs as $arc) {
            $stmt->bindParam(':character_id', $charId);
            $stmt->bindParam(':arc_name', $arc->arc_name);
            $stmt->bindParam(':status', $arc->status);
            $stmt->bindParam(':arc_photo_url', $arc->arc_photo_url);
            $stmt->execute();
        }
    }

    public function saveAbilities(int $charId, array $abilities): void {
        // Delete old abilities first
        $delQuery = "DELETE FROM character_abilities WHERE character_id = :id";
        $delStmt = $this->db->prepare($delQuery);
        $delStmt->bindParam(':id', $charId);
        $delStmt->execute();

        // Insert new abilities
        $query = "INSERT INTO character_abilities (character_id, ability_name, ability_type, description, ability_photo_url) 
                  VALUES (:character_id, :ability_name, :ability_type, :description, :ability_photo_url)";
        $stmt = $this->db->prepare($query);
        
        foreach ($abilities as $ability) {
            $stmt->bindParam(':character_id', $charId);
            $stmt->bindParam(':ability_name', $ability->ability_name);
            $stmt->bindParam(':ability_type', $ability->ability_type);
            $stmt->bindParam(':description', $ability->description);
            $stmt->bindParam(':ability_photo_url', $ability->ability_photo_url);
            $stmt->execute();
        }
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM characters WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    private function mapRowToCharacter(array $row): Character {
        $char = new Character(
            $row['name'],
            $row['epithet'],
            $row['bounty'],
            $row['devil_fruit'],
            $row['photo_url'],
            $row['general_information']
        );
        $char->id = $row['id'];
        $char->created_at = $row['created_at'];
        $char->updated_at = $row['updated_at'];
        return $char;
    }
}
