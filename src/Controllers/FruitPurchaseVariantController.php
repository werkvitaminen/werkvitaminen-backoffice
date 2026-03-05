<?php

namespace App\Controllers;

use App\Models\FruitPurchaseVariant;
use App\Core\View;

class FruitPurchaseVariantController
{
    protected $model;

    public function __construct()
    {
        $this->model = new FruitPurchaseVariant();
    }

    public function create()
    {
        $fruitTypeId = $_GET['fruit_type_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;

            $this->model->save($data);

            header("Location: /fruittypes/view/" . $data['fruit_type_id']);
            exit;
        }

        View::render('variants/form', [
            'title' => 'Variant toevoegen',
            'item' => [
                'fruit_type_id' => $fruitTypeId
            ],
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

            header("Location: /fruittypes/view/" . $data['fruit_type_id']);
            exit;
        }

        View::render('variants/form', [
            'title' => 'Variant bewerken',
            'item' => $item,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function delete($id)
    {
        $variant = $this->model->find($id);

        $this->model->delete($id);

        header("Location: /fruittypes/view/" . $variant['fruit_type_id']);
        exit;
    }
}