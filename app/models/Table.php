<?php
namespace App\Models;

use App\Core\Model;

class Table extends Model
{
    /**
     * Récupère toutes les tables
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM tables ORDER BY name";
        return $this->fetchAll($sql);
    }

    /**
     * Récupère une table par son ID
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM tables WHERE id = :id";
        return $this->fetch($sql, ['id' => $id]);
    }

    /**
     * Crée une nouvelle table
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO tables (name, seats, status)
                VALUES (:name, :seats, :status)";

        $this->execute($sql, [
            'name'   => $data['name'],
            'seats'  => $data['seats'],
            'status' => $data['status'] ?? 'libre',
        ]);

        return $this->lastInsertId();
    }

    /**
     * Met à jour une table
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE tables
                SET name = :name,
                    seats = :seats,
                    status = :status
                WHERE id = :id";

        return $this->execute($sql, [
            'name'   => $data['name'],
            'seats'  => $data['seats'],
            'status' => $data['status'],
            'id'     => $id,
        ]);
    }

    /**
     * Change uniquement le statut d'une table
     */
    public function setStatus(int $id, string $status): bool
    {
        $sql = "UPDATE tables SET status = :status WHERE id = :id";
        return $this->execute($sql, [
            'status' => $status,
            'id'     => $id,
        ]);
    }

    /**
     * Supprime une table
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tables WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }
}