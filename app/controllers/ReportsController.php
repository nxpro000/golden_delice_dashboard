<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Report;

class ReportsController extends Controller
{
    private Report $reportModel;

    public function __construct()
    {
        parent::__construct();
        $this->reportModel = new Report();
    }

    public function index()
    {
        $stats = [
            'sales_total' => $this->reportModel->getSalesTotal(date('Y-m-d'), date('Y-m-d')),
            // Ajoute ici les autres stats que tu veux afficher
        ];

        $this->render('reports/index', compact('stats'), 'Statistiques');
    }
}
