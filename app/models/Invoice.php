<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Invoice extends Model
{
    public function createForOrder(array $order): int
    {
        $number = 'INV-' . date('Ymd') . '-' . $order['id'];

        $sql = "INSERT INTO invoices (order_id, number, total_ttc, payment_method, paid_at)
                VALUES (:order_id, :number, :total_ttc, :payment_method, NOW())";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'order_id'       => $order['id'],
            'number'         => $number,
            'total_ttc'      => $order['total_ttc'],
            'payment_method' => $order['payment_method'],
        ]);
        return (int)self::$db->lastInsertId();
    }

    public function findByOrderId(int $orderId): ?array
    {
        $sql = "SELECT * FROM invoices WHERE order_id = :order_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }
}
