<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Preparation extends Model
{
    public function create(array $data): int
    {
        $sql = "INSERT INTO preparations (name, total_portions, portions_remaining, created_at)
                VALUES (:name, :total_portions, :portions_remaining, NOW())";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'name'              => $data['name'],
            'total_portions'    => $data['total_portions'],
            'portions_remaining'=> $data['total_portions'],
        ]);
        return (int)self::$db->lastInsertId();
    }

    public function consumePortions(int $id, int $qty): void
    {
        $sql = "UPDATE preparations
                SET portions_remaining = portions_remaining - :qty
                WHERE id = :id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'qty' => $qty,
            'id'  => $id,
        ]);
    }

    public function getAllToday(): array
    {
        $sql = "SELECT * FROM preparations WHERE DATE(created_at) = CURDATE()";
        return self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM preparations ORDER BY created_at DESC";
        return $this->fetchAll($sql);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM preparations WHERE id = :id";
        return $this->fetch($sql, ['id' => $id]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE preparations
                SET name = :name,
                    total_portions = :total_portions,
                    portions_remaining = :portions_remaining
                WHERE id = :id";

        return $this->execute($sql, [
            'name'               => $data['name'],
            'total_portions'     => $data['total_portions'],
            'portions_remaining' => $data['portions_remaining'],
            'id'                 => $id,
        ]);
    }


    public function delete(int $id): bool
    {
        $sql = "DELETE FROM preparations WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }

    
    public function resetDaily(): void
    {
        $sql = "DELETE FROM preparations WHERE DATE(created_at) < CURDATE()";
        self::$db->query($sql);
    }

}
