<?php
// app/Core/Router.php

namespace App\Core;

class Router
{
    public function run(): void
    {
       
        // Récupération de l'URL
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');

        // Découpage
        $segments = $url ? explode('/', $url) : [];

        // Controller
        $controllerName = !empty($segments[0])
            ? ucfirst($segments[0]) . 'Controller'
            : 'DashboardController';

        // Méthode
        $method = $segments[1] ?? 'index';

        // Paramètres
        $params = array_slice($segments, 2);

        // Namespace complet
        $controllerClass = '\\App\\Controllers\\' . $controllerName;

        // Vérification du controller
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller introuvable : $controllerClass");
        }

        $controller = new $controllerClass();

        // Vérification de la méthode
        if (!method_exists($controller, $method)) {
            throw new \Exception("Méthode introuvable : $method dans $controllerClass");
        }

        // Exécution
        call_user_func_array([$controller, $method], $params);
    }
}