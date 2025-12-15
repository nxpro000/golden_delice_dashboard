<?php
use Dotenv\Dotenv;
// public/index.php

// 1. Chargement de l'autoload (Composer ou autoloader maison)
require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// 2. Chargement de la configuration (BDD, constantes)
require_once dirname(__DIR__) . '/app/Config/config.php';

use App\Core\Router;

// 3. Instanciation du routeur
$router = new Router();

// 4. Lancement du routeur
try {
    $router->run();
} catch (Exception $e) {
    // Gestion simple des erreurs (à améliorer selon ton besoin)
    echo "<h1>Erreur</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}