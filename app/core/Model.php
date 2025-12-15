<?php
// app/Core/Model.php

namespace App\Core;

use PDO;
use PDOException;

abstract class Model
{
    /**
     * Instance PDO partagée par tous les modèles
     * @var PDO
     */
    protected static PDO $db;

    /**
     * Constructeur : initialise la connexion si nécessaire
     */
    public function __construct()
    {
        if (!isset(self::$db)) {
            $this->initDatabase();
        }
    }

    /**
     * Initialise la connexion PDO
     */
    private function initDatabase(): void
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

        try {
            self::$db = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            if (APP_DEBUG) {
                die("Erreur de connexion à la base : " . $e->getMessage());
            }
            die("Impossible de se connecter à la base de données.");
        }
    }

    /**
     * Raccourci pour exécuter une requête simple
     */
    protected function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Raccourci pour récupérer une seule ligne
     */
    protected function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Raccourci pour récupérer plusieurs lignes
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Raccourci pour exécuter une requête INSERT/UPDATE/DELETE
     */
    protected function execute(string $sql, array $params = []): bool
    {
        $stmt = self::$db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Récupère l'ID du dernier insert
     */
    protected function lastInsertId(): int
    {
        return (int) self::$db->lastInsertId();
    }
}
