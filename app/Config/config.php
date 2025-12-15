<?php
// app/Config/config.php

// ⚠ À adapter avec tes vraies infos de connexion
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);

// Chemins utiles
define('BASE_URL', '/golden-delice-manager/public/'); // si ton projet est à la racine du virtualhost
// Exemple si ton projet est dans /golden-delice : define('BASE_URL', '/golden-delice/');

// Optionnel : paramètres généraux
define('APP_NAME', 'Golden Délice – Back-office');
define('APP_ENV', 'dev'); // ou 'prod'
define('APP_DEBUG', true);
