<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\FruitBoxType;

class FruitBoxTypeController
{
    private $model;

    public function __construct()
    {
        $this->model = new FruitBoxType();
    }

    public function index()
    {
        $items = $this->model->all($_GET['search'] ?? null);

        View::render('boxtypes/index', [
            'title' => 'Fruitbox types',
            'items' => $items,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function show($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            $_SESSION['error'] = 'Fruitbox type niet gevonden';
            header('Location: /boxtypes');
            exit;
        }

        View::render('boxtypes/show', [
            'title' => 'Fruitbox type bekijken',
            'item' => $item,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $result = $this->model->save($_POST);

            if (!empty($result['error'])) {
                View::render('boxtypes/form', [
                    'title' => 'Nieuwe fruitbox type',
                    'item' => $_POST,
                    'fields' => $this->model->getFieldsConfig(),
                    'error' => $result['error']
                ]);
                return;
            }

            header('Location: /boxtypes');
            exit;
        }

        View::render('boxtypes/form', [
            'title' => 'Nieuwe fruitbox type',
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

            $result = $this->model->save($data);

            if (!empty($result['error'])) {
                View::render('boxtypes/form', [
                    'title' => 'Fruitbox type bewerken',
                    'item' => $data,
                    'fields' => $this->model->getFieldsConfig(),
                    'error' => $result['error']
                ]);
                return;
            }

            header('Location: /boxtypes');
            exit;
        }

        View::render('boxtypes/form', [
            'title' => 'Fruitbox type bewerken',
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

        header('Location: /boxtypes');
        exit;
    }
}