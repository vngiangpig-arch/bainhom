<?php
class BankController {
    private $bankModel;

    public function __construct($model) {
        $this->bankModel = $model;
    }

    public function handleRequest() {
        $action = $_POST['action'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if ($action === 'add') $this->bankModel->addBank($_POST['tenbank'], $_POST['chutaikhoan'], $_POST['sotaikhoan']);
            elseif ($action === 'edit') $this->bankModel->updateBank($_POST['id'], $_POST['tenbank'], $_POST['chutaikhoan'], $_POST['sotaikhoan']);
            elseif ($action === 'delete') $this->bankModel->deleteBank($_POST['id']);
            header('Location: index.php?page=bank'); 
            exit();
        }

        $banks = $this->bankModel->getBanks();
        require_once __DIR__ . "/../view/bank/bank.php";
    }
}
?>