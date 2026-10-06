<?php
class PlanModel {
    private $pdo;

    public function __construct($pdoConnection) {
        $this->pdo = $pdoConnection;
    }

    public function getPlans() {
        return $this->pdo->query("SELECT * FROM plan ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPlan($name, $price, $device, $time, $description) {
        $sql = "INSERT INTO plan (name, price, device, time, description) VALUES (:name, :price, :device, :time, :description)";
        return $this->pdo->prepare($sql)->execute(['name' => $name, 'price' => $price, 'device' => $device, 'time' => $time, 'description' => $description]);
    }

    public function updatePlan($id, $name, $price, $device, $time, $description) {
        $sql = "UPDATE plan SET name = :name, price = :price, device = :device, time = :time, description = :description WHERE id = :id";
        return $this->pdo->prepare($sql)->execute(['name' => $name, 'price' => $price, 'device' => $device, 'time' => $time, 'description' => $description, 'id' => $id]);
    }

    public function deletePlan($id) {
        return $this->pdo->prepare("DELETE FROM plan WHERE id = :id")->execute(['id' => $id]);
    }
}
?>