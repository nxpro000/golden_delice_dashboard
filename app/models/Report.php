<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Report extends Model
{
    public function getSalesTotal($from, $to)
    {
        $sql = "SELECT COALESCE(SUM(total_ttc),0) AS total
                FROM orders
                WHERE DATE(created_at) BETWEEN :from AND :to
                AND status='paid'";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['from'=>$from,'to'=>$to]);
        return (float)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getOrdersCount($from, $to)
    {
        $sql = "SELECT COUNT(*) AS nb
                FROM orders
                WHERE DATE(created_at) BETWEEN :from AND :to";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['from'=>$from,'to'=>$to]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['nb'];
    }

    public function getCoversCount($from, $to)
    {
        $sql = "SELECT COALESCE(SUM(covers),0) AS covers
                FROM orders
                WHERE DATE(created_at) BETWEEN :from AND :to
                AND type='interne'";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['from'=>$from,'to'=>$to]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['covers'];
    }

    public function getOngoingOrders()
    {
        $sql = "SELECT o.*, t.name AS table_name
                FROM orders o
                LEFT JOIN tables t ON t.id=o.table_id
                WHERE o.status IN ('en_cours','envoye_cuisine','pret','en_attente_paiement')
                ORDER BY o.created_at DESC";
        return self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTablesStatus()
    {
        return self::$db->query("SELECT * FROM tables ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopDishes($from, $to, $limit=5)
    {
        $sql = "SELECT d.name, SUM(oi.quantity) AS qty
                FROM order_items oi
                JOIN dishes d ON d.id=oi.dish_id
                JOIN orders o ON o.id=oi.order_id
                WHERE DATE(o.created_at) BETWEEN :from AND :to
                AND o.status='paid'
                GROUP BY d.id
                ORDER BY qty DESC
                LIMIT :limit";
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(':from',$from);
        $stmt->bindValue(':to',$to);
        $stmt->bindValue(':limit',$limit,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCancelledOrders($from, $to)
    {
        $sql = "SELECT * FROM orders
                WHERE DATE(created_at) BETWEEN :from AND :to
                AND status='cancelled'";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['from'=>$from,'to'=>$to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaymentsSummary($from, $to)
    {
        $sql = "SELECT payment_method, SUM(total_ttc) AS total
                FROM orders
                WHERE DATE(created_at) BETWEEN :from AND :to
                AND status='paid'
                GROUP BY payment_method";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(['from'=>$from,'to'=>$to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodayPreparations()
    {
        return self::$db->query("SELECT * FROM preparations WHERE DATE(created_at)=CURDATE()")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableDishes()
    {
        $sql = "SELECT d.id, d.name, d.price,
                MIN(p.portions_remaining / dc.quantity_required) AS max_portions
                FROM dishes d
                JOIN dish_components dc ON dc.dish_id=d.id
                JOIN preparations p ON p.id=dc.preparation_id
                GROUP BY d.id";
        return self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
