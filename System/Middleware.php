<?php
class Middleware
{
    public static function requireLogin()
    {
       

        $uri = $_GET['url'] ?? '';
        $uri = strtolower(trim($uri));

        // Rutas libres
        $excepciones = [
            '', 'auth', 'auth/login', 'auth/register', 'home',
            'assets/',  'imagen/', 'css/', 'js/'
        ];

        foreach ($excepciones as $libre) {
            if (str_starts_with($uri, $libre)) {
                return;
            }
        }

        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "Auth");
            exit;
        }
    }
}
