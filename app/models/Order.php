<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Order extends Model
{
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO orders (type, table_id, covers, status, created_at)
                VALUES (:type, :table_id, :covers, 'en_cours', NOW())";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            'type'     => $data['type'],
            'table_id' => $data['table_id'] ?? null,
            'covers'   => $data['covers'] ?? 0,
        ]);
        return (int)self::$db->lastInsertId();
    }

    public function updateTotals(int $orderId): void
    {
        $sql = "SELECT COALESCE(SUM(total_price),0) AS total
                FROM order_items WHERE order_id = :order_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        $total = (float)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $sql = "UPDATE orders
                SET total_ht = :total, total_ttc = :total
                WHERE id = :id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['total' => $total, 'id' => $orderId]);
    }

    public function setStatus(int $orderId, string $status): void
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['status' => $status, 'id' => $orderId]);
    }

    public function list(array $filters = []): array
    {
        $sql = "SELECT * FROM orders WHERE 1=1";
        $params = [];

        if (!empty($filters['from']) && !empty($filters['to'])) {
            $sql .= " AND DATE(created_at) BETWEEN :from AND :to";
            $params['from'] = $filters['from'];
            $params['to']   = $filters['to'];
        }
        if (!empty($filters['type'])) {
            $sql .= " AND type = :type";
            $params['type'] = $filters['type'];
        }
        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        $sql .= " ORDER BY created_at DESC";
        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function payOrder(int $id, string $paymentMethod, float $amountPaid, float $change): bool
    {
        $sql = "UPDATE orders
                SET status='paid',
                    payment_method=:pm,
                    amount_paid=:amount_paid,
                    change_amount=:change_amount,
                    closed_at = NOW()
                WHERE id=:id";

        return $this->execute($sql, [
            'pm'            => $paymentMethod,
            'amount_paid'   => $amountPaid,
            'change_amount' => $change,
            'id'            => $id,
        ]);
    }

}
