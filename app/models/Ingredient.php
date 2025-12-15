<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Ingredient extends Model
{
    public function getAll(): array
    {
        return self::$db->query("SELECT * FROM ingredients ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStock(int $id, float $delta): void
    {
        $sql = "UPDATE ingredients
                SET stock_current = stock_current + :delta
                WHERE id = :id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'delta' => $delta,
            'id'    => $id,
        ]);
    }
}
