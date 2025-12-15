<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Dish;
use App\Models\DishOption;
use App\Models\Ingredient;

class DishesController extends Controller
{
    private Dish $dishModel;
    private DishOption $optionModel;
    private Ingredient $ingredientModel;

    public function __construct()
    {
        parent::__construct();
        $this->dishModel = new Dish();
        $this->optionModel = new DishOption();
        $this->ingredientModel = new Ingredient();
    }

    public function index()
    {
        $dishes = $this->dishModel->getAllActive(); //->getAll()
        $this->render('dishes/index', compact('dishes'), 'Plats');
    }
}