<?php
class PlanController {
    private $planModel;

    public function __construct($model) {
        $this->planModel = $model;
    }

    public function handleRequest() {
     $action = $_POST['action'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($action === 'add'|| $action === 'edit' ) {
            $name = trim($_POST['name'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $device = trim($_POST['device'] ?? '');
            $time = trim($_POST['time'] ?? '');
            $description = trim($_POST['description'] ?? '');
            

            if (empty($name) || empty($price) || empty($device) || empty($time) || empty($description)) {
                $_SESSION['error_message'] = "Bạn phải nhập đầy đủ thông tin!"; 
                header('Location: index.php?page=plan'); 
                exit();
            }

            if (!is_numeric($price) || (float)$price < 0) {
                $_SESSION['error_message'] = "Giá tiền không được là số âm!"; 
                header('Location: index.php?page=plan'); 
                exit();
            }
            if (!is_numeric($time) || (float)$time < 0) {
                $_SESSION['error_message'] = "Số ngày (time) không được là số âm!"; 
                header('Location: index.php?page=plan'); 
                exit();
            }
            if (!is_numeric($device) || (float)$device < 0) {
                        $_SESSION['error_message'] = "Số thiết bị không được là số âm!"; 
                        header('Location: index.php?page=plan'); 
                        exit();
                    }


        }
            if ($action === 'add') $this->planModel->addPlan($_POST['name'], $_POST['price'], $_POST['device'], $_POST['time'], $_POST['description']);
            elseif ($action === 'edit') $this->planModel->updatePlan($_POST['id'], $_POST['name'], $_POST['price'], $_POST['device'], $_POST['time'], $_POST['description']);
            elseif ($action === 'delete') $this->planModel->deletePlan($_POST['id']);
            header('Location: index.php?page=plan'); 
            exit();
        }

        $plans = $this->planModel->getPlans();
        require_once __DIR__ . "/../view/plan/plan.php";
    }
}
?>