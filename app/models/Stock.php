<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Stock extends Model
{
    public function getLowStockItems()
    {
        $sql = "SELECT * FROM ingredients
                WHERE stock_current <= alert_threshold
                ORDER BY stock_current ASC";
        return self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
