<?php
class BankModel {
    private $pdo;

    public function __construct($pdoConnection) {
        $this->pdo = $pdoConnection;
    }

    public function getBanks() {
        return $this->pdo->query("SELECT * FROM bank ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBank($tenbank, $chutaikhoan, $sotaikhoan) {
        $stmt = $this->pdo->prepare("INSERT INTO bank (tenbank, chutaikhoan, sotaikhoan) VALUES (?, ?, ?)");
        return $stmt->execute([$tenbank, $chutaikhoan, $sotaikhoan]);
    }

    public function updateBank($id, $tenbank, $chutaikhoan, $sotaikhoan) {
        $stmt = $this->pdo->prepare("UPDATE bank SET tenbank = ?, chutaikhoan = ?, sotaikhoan = ? WHERE id = ?");
        return $stmt->execute([$tenbank, $chutaikhoan, $sotaikhoan, $id]);
    }

    public function deleteBank($id) {
        return $this->pdo->prepare("DELETE FROM bank WHERE id = ?")->execute([$id]);
    }
}
?>