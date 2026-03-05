<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class BaseModel
{
    protected $pdo;
    protected $table;
    protected $fieldsConfig = []; // veldconfig geladen uit config
    protected $restrictRelations = [];
    
    public function __construct($table, $fieldsConfig = [])
    {
        $this->pdo = Database::getInstance();
        $this->table = $table;
        $this->fieldsConfig = $fieldsConfig;
    }

    public function getFieldsConfig() 
    {
        return $this->fieldsConfig;
    }

    // --- Searchable fields uit config halen ---
    protected function getSearchableFields()
    {
        $searchable = [];
        foreach ($this->fieldsConfig as $name => $props) {
            if (!empty($props['searchable'])) {
                $searchable[] = $name;
            }
        }
        return $searchable;
    }

    // --- Haal alle records, eventueel search ---
    public function all($search = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        $searchable = $this->getSearchableFields();
        if ($search && !empty($searchable)) {
            $where = [];
            foreach ($searchable as $field) {
                $where[] = "$field LIKE :s";
            }
            $sql .= " WHERE " . implode(' OR ', $where);
            $params[':s'] = "%$search%";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Haal 1 record op ---
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- Insert of Update ---
    public function save($data)
    {

        
        foreach ($this->fieldsConfig as $name => $props) {
            if (($props['type'] ?? null) === 'checkbox' && !array_key_exists($name, $data)) {
                $data[$name] = 0; // niet aangevinkt → false
            }

            if (($props['type'] ?? '') === 'password') {
                // Edit mode: leeg password = overslaan
                if (isset($data['id']) && empty($data[$name])) {
                    unset($data[$name]);
                    continue;
                }

                // Nieuwe wachtwoord validatie
                if (!empty($data[$name])) {
                    if (!$this->validatePassword($data[$name])) {
                        throw new \Exception("Wachtwoord moet minimaal 6 tekens, 1 hoofdletter en 1 speciaal teken bevatten.");
                    }
                    // Hash wachtwoord
                    $data[$name] = password_hash($data[$name], PASSWORD_BCRYPT);
                }
            }
        }

        if (!empty($data['id'])) {
            // Update
            $id = $data['id'];
            unset($data['id']);
            $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $set WHERE id = :id");
            $data['id'] = $id;
            return $stmt->execute($data);
        } else {
            // Insert
            $keys = implode(',', array_keys($data));
            $placeholders = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($keys) VALUES ($placeholders)");
            return $stmt->execute($data);
        }
    }

    // --- Delete record ---
    public function delete($id)
    {
        // Controleer restrict-relaties
        if (!empty($this->restrictRelations)) {

            foreach ($this->restrictRelations as $table => $foreignKey) {

                $stmt = $this->pdo->prepare(
                    "SELECT COUNT(*) FROM {$table} WHERE {$foreignKey} = :id"
                );

                $stmt->execute([':id' => $id]);

                if ($stmt->fetchColumn() > 0) {
                    throw new \Exception(
                        "Verwijderen niet toegestaan: er bestaan gekoppelde records in {$table}."
                    );
                }
            }
        }

        $stmt = $this->pdo->prepare(
            "DELETE FROM {$this->table} WHERE id = :id"
        );

        return $stmt->execute([':id' => $id]);
    }

    // Helper functie
    protected function validatePassword($password): bool
    {
        if (strlen($password) < 6) return false;
        if (!preg_match('/[A-Z]/', $password)) return false;       // minstens 1 hoofdletter
        if (!preg_match('/[\W]/', $password)) return false;        // minstens 1 speciaal teken
        return true;
    }

    public function where($column, $value)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE {$column} = :value"
        );
        $stmt->execute([':value' => $value]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function hasRelations($id, array $relations)
    {
        foreach ($relations as $table => $foreignKey) {

            $stmt = $this->pdo->prepare(
                "SELECT COUNT(*) FROM {$table} WHERE {$foreignKey} = :id"
            );
            $stmt->execute([':id' => $id]);

            if ($stmt->fetchColumn() > 0) {
                return true;
            }
        }

        return false;
    }
}