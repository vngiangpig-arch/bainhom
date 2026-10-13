<?php
class LoginControllers {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['status'] === 'Banned') {
                    $error = "Tài khoản của bạn đã bị khóa!";
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: index.php");
                    exit();
                }
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
            }
        }
        
        require_once __DIR__ . '/../view/login/login.php'; 
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit();
    }
}
?>