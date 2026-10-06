<?php
class PlanController {
    private $planModel;

    public function __construct($model) {
        $this->planModel = $model;
    }

    public function handleRequest() {
        $action = $_POST['action'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
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