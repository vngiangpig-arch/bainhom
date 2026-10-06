<?php
class UserModel {
    private $pdo;

    public function __construct($pdoConnection) {
        $this->pdo = $pdoConnection;
    }

    public function getUsers() {
        $sql = "SELECT u.*, p.name as plan_name FROM user u LEFT JOIN plan p ON u.plan_id = p.id ORDER BY u.id DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($username, $email, $password, $role, $price, $status, $plan_id) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (username, email, password, role, price, status, plan_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->pdo->prepare($sql)->execute([$username, $email, $hashed_password, $role, $price, $status, $plan_id]);
    }

    public function updateUser($id, $username, $email, $role, $price, $status, $plan_id) {
        $sql = "UPDATE user SET username = ?, email = ?, role = ?, price = ?, status = ?, plan_id = ? WHERE id = ?";
        return $this->pdo->prepare($sql)->execute([$username, $email, $role, $price, $status, $plan_id, $id]);
    }

    public function deleteUser($id) {
        return $this->pdo->prepare("DELETE FROM user WHERE id = ?")->execute([$id]);
    }

    public function banUser($id, $current_status) {
        $new_status = ($current_status === 'Active') ? 'Banned' : 'Active';
        return $this->pdo->prepare("UPDATE user SET status = ? WHERE id = ?")->execute([$new_status, $id]);
    }

    public function resetUserDevice($id) {
        return $this->pdo->prepare("UPDATE user SET device = NULL WHERE id = ?")->execute([$id]);
    }
}
?>