<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Table;

class TablesController extends Controller
{
    private Table $tableModel;

    public function __construct()
    {
        parent::__construct();
        $this->tableModel = new Table();
    }

    public function index(): void
    {
        $tables = $this->tableModel->getAll();

        $this->render('tables/index', [
            'tables' => $tables
        ], 'Gestion des tables');
    }

    public function edit(int $id): void
    {
        $table = $this->tableModel->find($id);

        if (!$table) {
            die('Table introuvable');
        }

        $this->render('tables/edit', [
            'table' => $table
        ], 'Modifier une table');
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $id     = (int)$_POST['id'];
        $name   = $_POST['name'];
        $seats  = (int)$_POST['seats'];
        $status = $_POST['status'];

        $this->tableModel->update($id, [
            'name'   => $name,
            'seats'  => $seats,
            'status' => $status
        ]);

        $this->redirect('/tables');
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name   = $_POST['name'];
            $seats  = (int)$_POST['seats'];
            $status = $_POST['status'] ?? 'libre';

            $this->tableModel->create([
                'name'   => $name,
                'seats'  => $seats,
                'status' => $status
            ]);

            $this->redirect('/tables');
        }

        $this->render('tables/create', [], 'Créer une table');
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id) {
            $this->tableModel->delete($id);
        }

        $this->redirect('/tables');
    }
}