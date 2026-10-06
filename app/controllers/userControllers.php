<?php
class UserController {
    private $userModel;
    private $planModel;

    public function __construct($userModel, $planModel) {
        $this->userModel = $userModel;
        $this->planModel = $planModel;
    }

    public function handleRequest() {
        $action = $_POST['action'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $id = $_POST['id'] ?? '';
            $plan_id = !empty($_POST['plan_id']) ? $_POST['plan_id'] : null;

            if ($action === 'add') $this->userModel->addUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['price'], $_POST['status'], $plan_id);
            elseif ($action === 'edit') $this->userModel->updateUser($id, $_POST['username'], $_POST['email'], $_POST['role'], $_POST['price'], $_POST['status'], $plan_id);
            elseif ($action === 'delete') $this->userModel->deleteUser($id);
            elseif ($action === 'ban') $this->userModel->banUser($id, $_POST['current_status']);
            elseif ($action === 'reset_device') $this->userModel->resetUserDevice($id);
            header('Location: index.php?page=user'); 
            exit();
        }

        $users = $this->userModel->getUsers();
        $plans = $this->planModel->getPlans();
        require_once __DIR__ . "/../view/user/user.php";
    }
}
?>