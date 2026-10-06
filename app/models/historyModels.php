<?php
require_once "database.php";
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
?>