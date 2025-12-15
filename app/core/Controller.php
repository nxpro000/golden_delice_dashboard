<?php
// app/Core/Controller.php

namespace App\Core;

class Controller
{
    public function __construct()
    {
        // Rien pour l’instant, mais extensible plus tard
    }
    /**
     * Charge une vue dans le layout principal.
     *
     * @param string $view Nom de la vue (ex: 'orders/index')
     * @param array $data Variables à passer à la vue
     * @param string|null $title Titre de la page (optionnel)
     */
    protected function render(string $view, array $data = [], ?string $title = null): void
    {
        // Extraction des variables pour la vue
        extract($data);

        // Chemin du fichier de vue
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \Exception("Vue introuvable : $viewFile");
        }

        // Titre de la page
        if ($title === null) {
            $title = APP_NAME;
        }

        // Chargement du layout global
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Redirection propre
     *
     * @param string $url
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . BASE_URL . ltrim($url, '/'));
        exit;
    }

    /**
     * Vérifie si la requête est POST
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Vérifie si la requête est GET
     */
    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Récupère une valeur POST sécurisée
     */
    protected function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Récupère une valeur GET sécurisée
     */
    protected function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }
}