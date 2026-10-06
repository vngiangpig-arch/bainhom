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
