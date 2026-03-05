<?php

namespace App\Controllers;

use App\Models\FruitType;
use App\Core\View;

class FruitTypeController
{
    protected $model;

    public function __construct()
    {
        $this->model = new FruitType();
    }

    public function index()
    {
        $items = $this->model->all($_GET['search'] ?? null);

        View::render('fruittypes/index', [
            'title' => 'Fruitsoorten',
            'items' => $items,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function show($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            $_SESSION['error'] = "Fruitsoort niet gevonden";
            header("Location: /fruittypes");
            exit;
        }

      
        $fruitPurchaseVariantModel = new \App\Models\FruitPurchaseVariant();
        $variants = $fruitPurchaseVariantModel->where('fruit_type_id', $id);

        View::render('fruittypes/show', [
            'title' => 'Fruitsoort bekijken',
            'fields' => $this->model->getFieldsConfig(),
            'item' => $item,
            'variants' => $variants,
            'fields_variants' => $fruitPurchaseVariantModel->getFieldsConfig()
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->save($_POST);
            header('Location: /fruittypes'); exit;
        }

        View::render('fruittypes/form', [
            'title' => 'Nieuwe fruitsoort',
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

            if (isset($_SESSION['backpage'])) {
                $backpage = $_SESSION['backpage'];
                unset($_SESSION['backpage']);
                header('Location: /fruittypes/'.$backpage.'/'.$id); exit;
            }
            else {
                header('Location: /customers'); exit;
            }

            header('Location: /fruittypes'); exit;
        }

         if (isset($_GET['backpage'])) {
            $_SESSION['backpage'] = $_GET['backpage'];
        }
        else {
            unset($_SESSION['backpage']);
        }

        View::render('fruittypes/form', [
            'title' => 'Fruitsoort bewerken',
            'item' => $item,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /fruittypes'); exit;
    }
}