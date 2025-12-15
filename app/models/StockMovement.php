<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class StockMovement extends Model
{
    public function create(array $data): void
    {
        $sql = "INSERT INTO stock_movements (ingredient_id, type, quantity, reason, created_at)
                VALUES (:ingredient_id, :type, :quantity, :reason, NOW())";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'ingredient_id' => $data['ingredient_id'],
            'type'          => $data['type'],
            'quantity'      => $data['quantity'],
            'reason'        => $data['reason'] ?? null,
        ]);
    }
}
