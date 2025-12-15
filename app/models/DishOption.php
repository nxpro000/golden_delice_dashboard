<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class DishOption extends Model
{
    public function getByDishAndType(int $dishId, string $type): array
    {
        $sql = "SELECT * FROM dish_options
                WHERE dish_id = :dish_id AND type = :type
                ORDER BY name";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'dish_id' => $dishId,
            'type'    => $type,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO dish_options (dish_id, type, name, price, is_default)
                VALUES (:dish_id, :type, :name, :price, :is_default)";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'dish_id'    => $data['dish_id'],
            'type'       => $data['type'],
            'name'       => $data['name'],
            'price'      => $data['price'] ?? 0,
            'is_default' => $data['is_default'] ?? 0,
        ]);
        return (int)self::$db->lastInsertId();
    }
}
