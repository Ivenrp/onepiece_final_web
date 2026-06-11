<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Exception\AppException;

class AuthController {
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function showLogin() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }
        require_once __DIR__ . '/../View/auth/login.php';
    }

    public function showRegister() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }
        require_once __DIR__ . '/../View/auth/register.php';
    }

    public function login() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new AppException("Invalid request method.");
            }
            
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->authService->login($username, $password);
            
            // Set session
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;

            header("Location: /");
            exit;
        } catch (AppException $e) {
            $error = $e->getMessage();
            require_once __DIR__ . '/../View/auth/login.php';
        }
    }

    public function register() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new AppException("Invalid request method.");
            }
            
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $this->authService->register($username, $email, $password);
            
            // Auto login after register
            $user = $this->authService->login($username, $password);
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;

            header("Location: /");
            exit;
        } catch (AppException $e) {
            $error = $e->getMessage();
            require_once __DIR__ . '/../View/auth/register.php';
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function showForgotPassword() {
        require_once __DIR__ . '/../View/auth/forgot_password.php';
    }

    public function processForgotPassword() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new AppException("Invalid request method.");
            }
            $email = $_POST['email'] ?? '';
            $token = $this->authService->generateResetToken($email);
            
            // Mock email sending
            $success = "Simulation: A reset link has been sent. <a href='/reset-password?email=".urlencode($email)."&token=".urlencode($token)."'>Click here to reset password</a>.";
            require_once __DIR__ . '/../View/auth/forgot_password.php';
        } catch (AppException $e) {
            $error = $e->getMessage();
            require_once __DIR__ . '/../View/auth/forgot_password.php';
        }
    }

    public function showResetPassword() {
        $email = $_GET['email'] ?? '';
        $token = $_GET['token'] ?? '';
        require_once __DIR__ . '/../View/auth/reset_password.php';
    }

    public function processResetPassword() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new AppException("Invalid request method.");
            }
            $email = $_POST['email'] ?? '';
            $token = $_POST['token'] ?? '';
            $newPassword = $_POST['password'] ?? '';

            $this->authService->resetPassword($email, $token, $newPassword);
            
            $success = "Password successfully reset! You can now <a href='/login'>Login</a>.";
            require_once __DIR__ . '/../View/auth/reset_password.php';
        } catch (AppException $e) {
            $error = $e->getMessage();
            $email = $_POST['email'] ?? '';
            $token = $_POST['token'] ?? '';
            require_once __DIR__ . '/../View/auth/reset_password.php';
        }
    }
}
