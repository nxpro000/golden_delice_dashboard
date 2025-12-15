<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Preparation;

class PreparationsController extends Controller
{
    private Preparation $prepModel;

    public function __construct()
    {
        parent::__construct();
        $this->prepModel = new Preparation();
    }

    public function index()
    {
        $preparations = $this->prepModel->getAll();
        $this->render('preparations/index', compact('preparations'), 'Préparations');
    }
}
