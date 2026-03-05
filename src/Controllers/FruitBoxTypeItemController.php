<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\FruitBoxTypeItem;
use App\Models\FruitType;

class FruitBoxTypeItemController
{
    private $model;

    public function __construct()
    {
        $this->model = new FruitBoxTypeItem();
    }

    public function create()
    {
        $boxTypeId = $_GET['box_type_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $data['box_type_id'] = $boxTypeId;

            $this->model->save($data);

            header("Location: /boxtypes/view/" . $boxTypeId);
            exit;
        }

        $fruitTypes = (new FruitType())->all();

        View::render('boxtypeitems/form', [
            'title' => 'Fruit toevoegen aan box',
            'item' => [],
            'fruit_types' => $fruitTypes,
            'box_type_id' => $boxTypeId,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function delete($id)
    {
        $item = $this->model->find($id);

        $boxTypeId = $item['box_type_id'];

        $this->model->delete($id);

        header("Location: /boxtypes/view/" . $boxTypeId);
        exit;
    }
}