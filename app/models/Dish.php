<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Dish extends Model
{

    public function getAll(): array
    {
        $sql = "SELECT d.*, c.name AS category_name
                FROM dishes d
                LEFT JOIN categories c ON c.id = d.category_id
                ORDER BY c.name, d.name";
        return self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActive(): array
    {
        $sql = "SELECT d.*, c.name AS category_name
                FROM dishes d
                LEFT JOIN categories c ON c.id = d.category_id
                WHERE d.is_active = 1
                ORDER BY c.name, d.name";
        return self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM dishes WHERE id = :id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO dishes (name, description, price, image, category_id, is_configurable, is_active)
                VALUES (:name, :description, :price, :image, :category_id, :is_configurable, 1)";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'name'           => $data['name'],
            'description'    => $data['description'] ?? null,
            'price'          => $data['price'] ?? 0,
            'image'          => $data['image'] ?? null,
            'category_id'    => $data['category_id'] ?? null,
            'is_configurable'=> $data['is_configurable'] ?? 0,
        ]);
        return (int)self::$db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $sql = "UPDATE dishes
                SET name=:name, description=:description, price=:price,
                    image=:image, category_id=:category_id,
                    is_configurable=:is_configurable
                WHERE id=:id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'name'           => $data['name'],
            'description'    => $data['description'] ?? null,
            'price'          => $data['price'] ?? 0,
            'image'          => $data['image'] ?? null,
            'category_id'    => $data['category_id'] ?? null,
            'is_configurable'=> $data['is_configurable'] ?? 0,
            'id'             => $id,
        ]);
    }

    public function deactivate(int $id): void
    {
        $sql = "UPDATE dishes SET is_active = 0 WHERE id = :id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}
