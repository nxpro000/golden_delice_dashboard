<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Report;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        $from = $_GET['from'] ?? date('Y-m-d');
        $to   = $_GET['to']   ?? date('Y-m-d');

        $report = new Report();
        $stock  = new Stock();

        $this->render('dashboard/index', [
            'from'            => $from,
            'to'              => $to,
            'salesTotal'      => $report->getSalesTotal($from,$to),
            'ordersCount'     => $report->getOrdersCount($from,$to),
            'coversCount'     => $report->getCoversCount($from,$to),
            'avgBasket'       => $report->getOrdersCount($from,$to) > 0 ? $report->getSalesTotal($from,$to)/$report->getOrdersCount($from,$to) : 0,
            'ongoingOrders'   => $report->getOngoingOrders(),
            'tablesStatus'    => $report->getTablesStatus(),
            'lowStock'        => $stock->getLowStockItems(),
            'preparations'    => $report->getTodayPreparations(),
            'availableDishes' => $report->getAvailableDishes(),
            'topDishes'       => $report->getTopDishes($from,$to),
            'cancelledOrders' => $report->getCancelledOrders($from,$to),
            'paymentsSummary' => $report->getPaymentsSummary($from,$to)
        ]);
    }
}
