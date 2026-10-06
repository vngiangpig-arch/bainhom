<?php
require_once "models.php";

$page = $_GET['page'] ?? 'dashboard';
$action = $_POST['action'] ?? '';
if ($page === 'historybank') {
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $action === 'delete') {
        deleteHistoryBank($_POST['id']);
        header('Location: index.php?page=historybank'); exit();
    }
    $historybanks = getHistoryBanks();
    require_once "Views/historybank.php";
}
elseif ($page === 'historyplan') {
    if ($_SERVER['REQUEST_METHOD'] === "POST" && $action === 'delete') {
        deleteHistoryPlan($_POST['id']);
        header('Location: index.php?page=historyplan'); exit();
    }
    $historyplans = getHistoryPlans();
    require_once "Views/historyplan.php";
}
else {
    require_once "Views/dashboard.php";
}


?>