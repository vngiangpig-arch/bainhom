<?php
require_once __DIR__ . "/../models/bankModels.php";

$page = $_GET['page'] ?? 'dashboard';
$action = $_POST['action'] ?? '';

if ($page === 'bank') {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($action === 'add') addBank($_POST['tenbank'], $_POST['chutaikhoan'], $_POST['sotaikhoan']);
        elseif ($action === 'edit') updateBank($_POST['id'], $_POST['tenbank'], $_POST['chutaikhoan'], $_POST['sotaikhoan']);
        elseif ($action === 'delete') deleteBank($_POST['id']);
        header('Location: index.php?page=bank'); exit();
    }
    $banks = getBanks();
    require_once __DIR__ . "/../view/bank.php";
}
else {
    require_once __DIR__ . "/../view/dashboard/dashboard.php";
}


?>