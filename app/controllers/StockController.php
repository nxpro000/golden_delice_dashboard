<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Ingredient;
use App\Models\StockMovement;

class StockController extends Controller
{
    public function index(): void
    {
        $ingredientModel = new Ingredient();
        $ingredients = $ingredientModel->getAll();

        $this->render('stock/index', [
            'ingredients' => $ingredients,
        ]);
    }

    public function entry(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $ingredientModel = new Ingredient();
            $this->render('stock/entry', [
                'ingredients' => $ingredientModel->getAll(),
            ]);
            return;
        }

        $ingredientId = (int)$_POST['ingredient_id'];
        $quantity     = (float)$_POST['quantity'];
        $reason       = $_POST['reason'] ?? 'Entrée stock';

        $ingredientModel   = new Ingredient();
        $stockMovementModel= new StockMovement();

        $stockMovementModel->create([
            'ingredient_id' => $ingredientId,
            'type'          => 'entry',
            'quantity'      => $quantity,
            'reason'        => $reason,
        ]);
        $ingredientModel->updateStock($ingredientId, $quantity);

        header('Location: /stock');
        exit;
    }

    public function exit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $ingredientModel = new Ingredient();
            $this->render('stock/exit', [
                'ingredients' => $ingredientModel->getAll(),
            ]);
            return;
        }

        $ingredientId = (int)$_POST['ingredient_id'];
        $quantity     = (float)$_POST['quantity'];
        $reason       = $_POST['reason'] ?? 'Sortie stock';

        $ingredientModel   = new Ingredient();
        $stockMovementModel= new StockMovement();

        $stockMovementModel->create([
            'ingredient_id' => $ingredientId,
            'type'          => 'exit',
            'quantity'      => $quantity,
            'reason'        => $reason,
        ]);
        $ingredientModel->updateStock($ingredientId, -$quantity);

        header('Location: /stock');
        exit;
    }
}
