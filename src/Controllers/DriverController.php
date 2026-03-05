<?php
namespace App\Controllers;

use App\Models\Driver;
use App\Core\View;

class DriverController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Driver();
    }

    public function index()
    {
        $drivers = $this->model->all($_GET['search'] ?? null);
        View::render('drivers/index', [
            'title' => 'Chauffeurs',
            'drivers' => $drivers,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->save($_POST);
            header('Location: /drivers'); exit;
        }

        View::render('drivers/form', [
            'title' => 'Nieuwe chauffeur',
            'item' => [],
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function edit($id)
    {
        $item = $this->model->find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['id'] = $id;
    
            $this->model->save($data);
            header('Location: /drivers'); exit;
        }

        View::render('drivers/form', [
            'title' => 'Chauffeur bewerken',
            'item' => $item,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header('Location: /drivers'); exit;
    }
}