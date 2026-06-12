<?php

namespace App\Controller;

use App\Service\CharacterService;
use App\Exception\AppException;

class CharacterController {
    private CharacterService $service;

    public function __construct(CharacterService $service) {
        $this->service = $service;
    }

    public function index() {
        $filters = [
            'search' => $_GET['search'] ?? '',
            'fruit' => $_GET['fruit'] ?? '',
            'sort' => $_GET['sort'] ?? ''
        ];
        
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        
        $data = $this->service->getCharactersWithPagination($filters, $page, 12);
        
        $characters = $data['characters'];
        $totalPages = $data['totalPages'];
        $currentPage = $data['currentPage'];
        $totalItems = $data['totalItems'];

        require_once __DIR__ . '/../View/characters/index.php';
    }

    public function dashboard() {
        $characters = $this->service->getAllCharacters();
        require_once __DIR__ . '/../View/admin/dashboard.php';
    }

    public function show() {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) throw new AppException("ID is missing.");
            
            $character = $this->service->getCharacterById((int)$id);
            require_once __DIR__ . '/../View/characters/show.php';
        } catch (AppException $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    public function adminShow() {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) throw new AppException("ID is missing.");
            
            $character = $this->service->getCharacterById((int)$id);
            require_once __DIR__ . '/../View/admin/show.php';
        } catch (AppException $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    public function create() {
        require_once __DIR__ . '/../View/characters/create.php';
    }

    public function store() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new AppException("Invalid request method.");
            }
            $this->service->createCharacter($_POST, $_FILES);
            header("Location: /dashboard");
            exit;
        } catch (AppException $e) {
            $error = $e->getMessage();
            require_once __DIR__ . '/../View/characters/create.php';
        }
    }

    public function edit() {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) throw new AppException("ID is missing.");
            
            $character = $this->service->getCharacterById((int)$id);
            require_once __DIR__ . '/../View/characters/edit.php';
        } catch (AppException $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    public function update() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new AppException("Invalid request method.");
            }
            $id = $_POST['id'] ?? null;
            if (!$id) throw new AppException("ID is missing.");

            $this->service->updateCharacter((int)$id, $_POST, $_FILES);
            header("Location: /dashboard");
            exit;
        } catch (AppException $e) {
            $error = $e->getMessage();
            // Need to fetch character again to populate the form on error
            $id = $_POST['id'] ?? null;
            if ($id) {
                $character = $this->service->getCharacterById((int)$id);
            }
            require_once __DIR__ . '/../View/characters/edit.php';
        }
    }

    public function destroy() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new AppException("Invalid request method.");
            }
            $id = $_POST['id'] ?? null;
            if (!$id) throw new AppException("ID is missing.");

            $this->service->deleteCharacter((int)$id);
            header("Location: /dashboard");
            exit;
        } catch (AppException $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    private function redirectWithError(string $message) {
        // A simple way to pass error without session for this simple app
        header("Location: /dashboard?error=" . urlencode($message));
        exit;
    }
}
