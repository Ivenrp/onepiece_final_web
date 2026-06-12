<?php

namespace App\Service;

use App\Domain\User;
use App\Repository\UserRepository;
use App\Exception\AppException;

class AuthService {
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function register(string $username, string $email, string $password): void {
        if (empty($username) || empty($email) || empty($password)) {
            throw new AppException("All fields are required for registration.");
        }

        if ($this->userRepository->findByUsername($username)) {
            throw new AppException("Username is already taken.");
        }

        if ($this->userRepository->findByEmail($email)) {
            throw new AppException("Email is already registered.");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user = new User($username, $email, $hashedPassword);

        if (!$this->userRepository->save($user)) {
            throw new AppException("Failed to register user.");
        }
    }

    public function login(string $username, string $password): User {
        if (empty($username) || empty($password)) {
            throw new AppException("Username and password are required.");
        }

        $user = $this->userRepository->findByUsername($username);

        if (!$user || !password_verify($password, $user->password)) {
            throw new AppException("Invalid username or password.");
        }

        return $user;
    }

    public function generateResetToken(string $email): string {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            throw new AppException("Email not found in our records.");
        }

        // Generate a random token
        $token = bin2hex(random_bytes(32));
        
        // Save to session to mock email sending
        $_SESSION['reset_token'] = [
            'email' => $email,
            'token' => $token,
            'expires' => time() + 3600 // 1 hour expiry
        ];

        return $token;
    }

    public function resetPassword(string $email, string $token, string $newPassword): void {
        if (!isset($_SESSION['reset_token']) || 
            $_SESSION['reset_token']['email'] !== $email || 
            $_SESSION['reset_token']['token'] !== $token) {
            throw new AppException("Invalid or expired reset token.");
        }

        if (time() > $_SESSION['reset_token']['expires']) {
            unset($_SESSION['reset_token']);
            throw new AppException("Reset token has expired.");
        }

        if (strlen($newPassword) < 6) {
            throw new AppException("Password must be at least 6 characters.");
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        if (!$this->userRepository->updatePassword($email, $hashedPassword)) {
            throw new AppException("Failed to update password.");
        }

        // Clear token after use
        unset($_SESSION['reset_token']);
    }

    public function changePassword(int $userId, string $currentPassword, string $newPassword, string $confirmPassword): void {
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            throw new AppException("All password fields are required.");
        }

        if (strlen($newPassword) < 6) {
            throw new AppException("New password must be at least 6 characters.");
        }

        if ($newPassword !== $confirmPassword) {
            throw new AppException("Password confirmation does not match.");
        }

        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new AppException("User account was not found.");
        }

        if (!password_verify($currentPassword, $user->password)) {
            throw new AppException("Current password is incorrect.");
        }

        if (password_verify($newPassword, $user->password)) {
            throw new AppException("New password must be different from current password.");
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        if (!$this->userRepository->updatePasswordById($userId, $hashedPassword)) {
            throw new AppException("Failed to update password.");
        }
    }
}
