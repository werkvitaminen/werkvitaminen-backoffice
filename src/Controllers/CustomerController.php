<?php
namespace App\Controllers;

use App\Models\Customer;
use App\Core\View;

class CustomerController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Customer();
    }

    public function index()
    {
        $customers = $this->model->all($_GET['search'] ?? null);
        View::render('customers/index', [
            'title' => 'Klanten',
            'customers' => $customers,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function show($id)
    {
        $customer = $this->model->find($id);

        if (!$customer) {
            header('Location: /customers');
            exit;
        }

        $locationModel = new \App\Models\CustomerLocation();
        $locations = $locationModel->where('customer_id', $id);

        View::render('customers/show', [
            'title' => 'Klant bekijken',
            'customer' => $customer,
            'fields' => $this->model->getFieldsConfig(),
            'locations' => $locations,
            'fields_location' => $locationModel->getFieldsConfig()
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->save($_POST);
            header('Location: /customers'); exit;
        }

        View::render('customers/form', [
            'title' => 'Nieuwe klant',
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
                header('Location: /customers/'.$backpage.'/'.$id); exit;
            }
            else {
                header('Location: /customers'); exit;
            }
            
        }

        if (isset($_GET['backpage'])) {
            $_SESSION['backpage'] = $_GET['backpage'];
        }
        else {
            unset($_SESSION['backpage']);
        }

        View::render('customers/form', [
            'title' => 'Klant bewerken',
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

        header('Location: /customers');
        exit;
    }
}