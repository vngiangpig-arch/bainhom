<?php
class HistoryController {
    private $historyModel;

    public function __construct($model) {
        $this->historyModel = $model;
    }

    public function handleBankRequest() {
        $action = $_POST['action'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === "POST" && $action === 'delete') {
            $this->historyModel->deleteHistoryBank($_POST['id']);
            header('Location: index.php?page=historybank'); 
            exit();
        }
        $historybanks = $this->historyModel->getHistoryBanks();
        require_once __DIR__ . "/../view/history/historybank.php";
    }

    public function handlePlanRequest() {
        $action = $_POST['action'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === "POST" && $action === 'delete') {
            $this->historyModel->deleteHistoryPlan($_POST['id']);
            header('Location: index.php?page=historyplan'); 
            exit();
        }
        $historyplans = $this->historyModel->getHistoryPlans();
        require_once __DIR__ . "/../view/history/historyplan.php";
    }
}
?>