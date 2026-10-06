<?php
require_once "database.php";
function getPlans() {
    global $pdo;
    return $pdo->query("SELECT * FROM plan ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}
function addPlan($name, $price, $device, $time, $description) {
    global $pdo;
    $sql = "INSERT INTO plan (name, price, device, time, description) VALUES (:name, :price, :device, :time, :description)";
    return $pdo->prepare($sql)->execute(['name'=>$name, 'price'=>$price, 'device'=>$device, 'time'=>$time, 'description'=>$description]);
}
function updatePlan($id, $name, $price, $device, $time, $description) {
    global $pdo;
    $sql = "UPDATE plan SET name = :name, price = :price, device = :device, time = :time, description = :description WHERE id = :id";
    return $pdo->prepare($sql)->execute(['name'=>$name, 'price'=>$price, 'device'=>$device, 'time'=>$time, 'description'=>$description, 'id'=>$id]);
}
function deletePlan($id) {
    global $pdo;
    return $pdo->prepare("DELETE FROM plan WHERE id = :id")->execute(['id' => $id]);
}
?>