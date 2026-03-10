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
        $fruitTypes = (new FruitType())->all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $data['box_type_id'] = $boxTypeId;

            // type-afhankelijke velden opschonen
            $data = $this->normalizeData($data);

            $result = $this->model->save($data);

            if (!empty($result['error'])) {

                View::render('boxtypeitems/form', [
                    'title' => 'Fruit toevoegen aan box',
                    'item' => $data,
                    'fields' => $this->model->getFieldsConfig(),
                    'fruit_types' => $fruitTypes,
                    'box_type_id' => $boxTypeId,
                    'error' => $result['error']
                ]);
                return;
            }

            header("Location: /boxtypes/view/" . $boxTypeId);
            exit;
        }

        View::render('boxtypeitems/form', [
            'title' => 'Fruit toevoegen aan box',
            'item' => [],
            'fruit_types' => $fruitTypes,
            'box_type_id' => $boxTypeId,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function edit($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            header("Location: /boxtypes");
            exit;
        }

        $fruitTypes = (new FruitType())->all();
        $boxTypeId = $item['box_type_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $data['id'] = $id;
            $data['box_type_id'] = $boxTypeId;

            $data = $this->normalizeData($data);

            $result = $this->model->save($data);

            if (!empty($result['error'])) {

                View::render('boxtypeitems/form', [
                    'title' => 'Fruit bewerken',
                    'item' => $data,
                    'fields' => $this->model->getFieldsConfig(),
                    'fruit_types' => $fruitTypes,
                    'error' => $result['error']
                ]);
                return;
            }

            header('Location: /boxtypes/view/' . $boxTypeId);
            exit;
        }

        View::render('boxtypeitems/form', [
            'title' => 'Fruit bewerken',
            'item' => $item,
            'fields' => $this->model->getFieldsConfig(),
            'fruit_types' => $fruitTypes,
        ]);
    }

    public function delete($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            header("Location: /boxtypes");
            exit;
        }

        $boxTypeId = $item['box_type_id'];

        $this->model->delete($id);

        header("Location: /boxtypes/view/" . $boxTypeId);
        exit;
    }

    /**
     * Zorgt dat ratio en fixed_range niet door elkaar worden opgeslagen
     */
    private function normalizeData($data)
    {
        if ($data['type'] === 'ratio') {

            $data['per_x_pieces'] = null;
            $data['quantity'] = null;

        } elseif ($data['type'] === 'per_x') {

            $data['ratio_value'] = null;
        }

        return $data;
    }
}