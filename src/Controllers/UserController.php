<?php
namespace App\Controllers;

use App\Models\User;
use App\Core\View;

class UserController
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $users = $this->model->all($_GET['search'] ?? null);
        View::render('users/index', [
            'title' => 'Gebruikers',
            'users' => $users,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

             try {
                $this->model->save($_POST);
                header('Location: /users');
                exit;
            } catch (\Exception $e) {
                $error = $e->getMessage();
                $item = $_POST;
                include __DIR__ . '/../Views/users/form.php';
            }
        }

        View::render('users/form', [
            'title' => 'Nieuwe Gebruiker',
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
    
            try {
                $this->model->save($data);
                header('Location: /users');
                exit;
            } catch (\Exception $e) {
                $error = $e->getMessage();
                $item = $_POST;
                include __DIR__ . '/../Views/users/form.php';
            }
        }

        View::render('users/form', [
            'title' => 'Gebruiker bewerken',
            'item' => $item,
            'fields' => $this->model->getFieldsConfig()
        ]);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header('Location: /users'); exit;
    }
}