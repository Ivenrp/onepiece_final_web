<?php

namespace App\Controller;

class HomeController {
    public function index() {
        require_once __DIR__ . '/../View/home/landing.php';
    }

    public function grandline() {
        require_once __DIR__ . '/../View/home/grandline.php';
    }

    public function profile() {
        require_once __DIR__ . '/../View/home/profile.php';
    }
}
