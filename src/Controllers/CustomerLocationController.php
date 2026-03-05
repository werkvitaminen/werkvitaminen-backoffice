<?php

namespace App\Controllers;

use App\Models\CustomerLocation;
use App\Models\Customer;
use App\Core\View;

class CustomerLocationController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CustomerLocation();
    }

    /*
    |--------------------------------------------------------------------------
    | Overzicht (optioneel, meestal niet nodig)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $locations = $this->model->all($_GET['search'] ?? null);

        View::render('locations/index', [
            'title' => 'Locaties',
            'locations' => $locations,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Nieuwe locatie aanmaken
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $customerId = $_GET['customer_id'] ?? null;

        if (!$customerId) {
            header('Location: /customers');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $data['customer_id'] = $customerId;

            $this->model->save($data);

            header("Location: /customers/view/$customerId");
            exit;
        }

        View::render('locations/form', [
            'title' => 'Nieuwe locatie',
            'item' => ['customer_id' => $customerId],
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Locatie bekijken (detail)
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $location = $this->model->find($id);

        if (!$location) {
            header('Location: /customers');
            exit;
        }

        $fruitBoxModel = new \App\Models\FruitBox();
        $boxes = $fruitBoxModel->where('customer_location_id', $id);

        View::render('locations/show', [
            'title' => 'Locatie bekijken',
            'location' => $location,
            'boxes' => $boxes
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Bewerken
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $item = $this->model->find($id);

        if (!$item) {
            header('Location: /customers');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $data['id'] = $id;

            $this->model->save($data);

            header("Location: /customers/view/" . $item['customer_id']);
            exit;
        }

        View::render('locations/form', [
            'title' => 'Locatie bewerken',
            'item' => $item,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Verwijderen
    |--------------------------------------------------------------------------
    */
    public function delete($id)
    {
        $location = $this->model->find($id);

        if ($location) {
            $customerId = $location['customer_id'];
            $this->model->delete($id);

            header("Location: /customers/view/$customerId");
            exit;
        }

        header('Location: /customers');
        exit;
    }
}