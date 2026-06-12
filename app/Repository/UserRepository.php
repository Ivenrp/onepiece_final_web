<?php

namespace App\Repository;

use App\Domain\User;
use PDO;

class UserRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findByUsername(string $username): ?User {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            return $this->mapRowToUser($row);
        }
        return null;
    }

    public function findByEmail(string $email): ?User {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            return $this->mapRowToUser($row);
        }
        return null;
    }

    public function findById(int $id): ?User {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            return $this->mapRowToUser($row);
        }
        return null;
    }

    public function save(User $user): bool {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':username', $user->username);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':password', $user->password);

        return $stmt->execute();
    }

    public function updatePassword(string $email, string $hashedPassword): bool {
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function updatePasswordById(int $id, string $hashedPassword): bool {
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function mapRowToUser(array $row): User {
        $user = new User(
            $row['username'],
            $row['email'],
            $row['password']
        );
        $user->id = $row['id'];
        $user->created_at = $row['created_at'];
        return $user;
    }
}
