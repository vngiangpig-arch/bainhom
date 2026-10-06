<?php
class HistoryModel {
    private $pdo;

    public function __construct($pdoConnection) {
        $this->pdo = $pdoConnection;
    }

    public function getHistoryBanks() {
        $sql = "SELECT h.*, u.username FROM historybank h LEFT JOIN user u ON h.user_id = u.id ORDER BY h.id DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteHistoryBank($id) {
        return $this->pdo->prepare("DELETE FROM historybank WHERE id = :id")->execute(['id' => $id]);
    }

    public function getHistoryPlans() {
        $sql = "SELECT hp.*, u.email, p.name AS plan_name FROM historyplan hp LEFT JOIN user u ON hp.user_id = u.id LEFT JOIN plan p ON hp.plan_id = p.id ORDER BY hp.id DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteHistoryPlan($id) {
        return $this->pdo->prepare("DELETE FROM historyplan WHERE id = :id")->execute(['id' => $id]);
    }
}
?>