<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class OrderItem extends Model
{
    public function addItem(int $orderId, int $dishId, int $qty, float $unitPrice, ?array $options = null): void
    {
        $sql = "INSERT INTO order_items (order_id, dish_id, quantity, unit_price, total_price, options)
                VALUES (:order_id, :dish_id, :quantity, :unit_price, :total_price, :options)";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'order_id'   => $orderId,
            'dish_id'    => $dishId,
            'quantity'   => $qty,
            'unit_price' => $unitPrice,
            'total_price'=> $unitPrice * $qty,
            'options'    => $options ? json_encode($options) : null,
        ]);
    }

    public function getItems(int $orderId): array
    {
        $sql = "SELECT oi.*, d.name
                FROM order_items oi
                JOIN dishes d ON d.id = oi.dish_id
                WHERE oi.order_id = :order_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
