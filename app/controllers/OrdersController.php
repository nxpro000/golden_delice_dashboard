<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dish;

class OrdersController extends Controller
{
    public function index(): void
    {
        $orderModel = new Order();
        $filters = [
            'from'   => $_GET['from']   ?? null,
            'to'     => $_GET['to']     ?? null,
            'type'   => $_GET['type']   ?? null,
            'status' => $_GET['status'] ?? null,
        ];
        $orders = $orderModel->list($filters);

        $this->render('orders/index', [
            'orders'  => $orders,
            'filters' => $filters,
        ]);
    }

    public function create(): void
    {
        $type   = $_GET['type']   ?? 'interne';
        $table  = $_GET['table']  ?? null;
        $covers = $_GET['covers'] ?? 0;

        $orderModel = new Order();
        $orderId = $orderModel->create([
            'type'     => $type,
            'table_id' => $table,
            'covers'   => $covers,
        ]);

        header('Location: /orders/edit?id=' . $orderId);
        exit;
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            die('Commande introuvable');
        }

        $orderModel     = new Order();
        $orderItemModel = new OrderItem();
        $dishModel      = new Dish();

        $order = $orderModel->find($id);
        if (!$order) {
            die('Commande introuvable');
        }

        $items = $orderItemModel->getItems($id);
        $dishes = $dishModel->getAllActive();

        $this->render('orders/edit', [
            'order'  => $order,
            'items'  => $items,
            'dishes' => $dishes,
        ]);
    }

    public function addItem(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $orderId = (int)$_POST['order_id'];
        $dishId  = (int)$_POST['dish_id'];
        $qty     = (int)$_POST['quantity'];

        $dishModel      = new Dish();
        $orderModel     = new Order();
        $orderItemModel = new OrderItem();

        $dish = $dishModel->find($dishId);
        if (!$dish) {
            die('Plat introuvable');
        }

        $options = !empty($_POST['options']) ? $_POST['options'] : null;

        $orderItemModel->addItem($orderId, $dishId, $qty, (float)$dish['price'], $options);
        $orderModel->updateTotals($orderId);

        header('Location: /orders/edit?id=' . $orderId);
        exit;
    }

    public function changeStatus(): void
    {
        $id     = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? null;

        if (!$id || !$status) {
            http_response_code(400);
            exit;
        }

        $orderModel = new Order();
        $orderModel->setStatus($id, $status);

        header('Location: /orders/edit?id=' . $id);
        exit;
    }

    public function pay(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $orderId       = (int)$_POST['order_id'];
        $paymentMethod = $_POST['payment_method'];
        $amountPaid    = (float)$_POST['amount_paid'];

        $orderModel  = new Order();
        $invoiceModel= new \App\Models\Invoice();

        $order = $orderModel->find($orderId);
        if (!$order) {
            die('Commande introuvable');
        }

        $change = $amountPaid - (float)$order['total_ttc'];

        // Mise à jour commande
        $orderModel->payOrder($orderId, $paymentMethod, $amountPaid, $change);

        // Créer facture
        $order['payment_method'] = $paymentMethod;
        $invoiceId = $invoiceModel->createForOrder($order);

        header('Location: /invoices/show?id=' . $invoiceId);
        exit;
    }

}
