<?php
require_once "database.php";

function getBanks() {
    global $pdo;
    return $pdo->query("SELECT * FROM bank ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}
function addBank($tenbank, $chutaikhoan, $sotaikhoan) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO bank (tenbank, chutaikhoan, sotaikhoan) VALUES (?, ?, ?)");
    return $stmt->execute([$tenbank, $chutaikhoan, $sotaikhoan]);
}
function updateBank($id, $tenbank, $chutaikhoan, $sotaikhoan) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE bank SET tenbank = ?, chutaikhoan = ?, sotaikhoan = ? WHERE id = ?");
    return $stmt->execute([$tenbank, $chutaikhoan, $sotaikhoan, $id]);
}
function deleteBank($id) {
    global $pdo;
    return $pdo->prepare("DELETE FROM bank WHERE id = ?")->execute([$id]);
}

function getUsers() {
    global $pdo;
    $sql = "SELECT u.*, p.name as plan_name FROM user u LEFT JOIN plan p ON u.plan_id = p.id ORDER BY u.id DESC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
function addUser($username, $email, $password, $role, $price, $status, $plan_id) {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (username, email, password, role, price, status, plan_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    return $pdo->prepare($sql)->execute([$username, $email, $hashed_password, $role, $price, $status, $plan_id]);
}
function updateUser($id, $username, $email, $role, $price, $status, $plan_id) {
    global $pdo;
    $sql = "UPDATE user SET username = ?, email = ?, role = ?, price = ?, status = ?, plan_id = ? WHERE id = ?";
    return $pdo->prepare($sql)->execute([$username, $email, $role, $price, $status, $plan_id, $id]);
}
function deleteUser($id) {
    global $pdo;
    return $pdo->prepare("DELETE FROM user WHERE id = ?")->execute([$id]);
}
function banUser($id, $current_status) {
    global $pdo;
    $new_status = ($current_status === 'Active') ? 'Banned' : 'Active';
    return $pdo->prepare("UPDATE user SET status = ? WHERE id = ?")->execute([$new_status, $id]);
}
function resetUserDevice($id) {
    global $pdo;
    return $pdo->prepare("UPDATE user SET device = NULL WHERE id = ?")->execute([$id]);
}
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
function getHistoryBanks() {
    global $pdo;
    $sql = "SELECT h.*, u.username FROM historybank h LEFT JOIN user u ON h.user_id = u.id ORDER BY h.id DESC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
function deleteHistoryBank($id) {
    global $pdo;
    return $pdo->prepare("DELETE FROM historybank WHERE id = :id")->execute(['id' => $id]);
}
function getHistoryPlans() {
    global $pdo;
    $sql = "SELECT hp.*, u.email, p.name AS plan_name FROM historyplan hp LEFT JOIN user u ON hp.user_id = u.id LEFT JOIN plan p ON hp.plan_id = p.id ORDER BY hp.id DESC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
function deleteHistoryPlan($id) {
    global $pdo;
    return $pdo->prepare("DELETE FROM historyplan WHERE id = :id")->execute(['id' => $id]);
}
