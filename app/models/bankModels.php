<?php
require_once __DIR__ . "/../../database/database.php";

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