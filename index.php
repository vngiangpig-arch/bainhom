<?php
require_once "models.php";

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
    require_once "Views/bank.php";
}
elseif ($page === 'user') {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $id = $_POST['id'] ?? '';
        $plan_id = !empty($_POST['plan_id']) ? $_POST['plan_id'] : null;
        if ($action === 'add') addUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['price'], $_POST['status'], $plan_id);
        elseif ($action === 'edit') updateUser($id, $_POST['username'], $_POST['email'], $_POST['role'], $_POST['price'], $_POST['status'], $plan_id);
        elseif ($action === 'delete') deleteUser($id);
        elseif ($action === 'ban') banUser($id, $_POST['current_status']);
        elseif ($action === 'reset_device') resetUserDevice($id);
        header('Location: index.php?page=user'); exit();
    }
    $users = getUsers();
    $plans = getPlans();
    require_once "Views/user.php";
}
elseif ($page === 'plan') {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($action === 'add') addPlan($_POST['name'], $_POST['price'], $_POST['device'], $_POST['time'], $_POST['description']);
        elseif ($action === 'edit') updatePlan($_POST['id'], $_POST['name'], $_POST['price'], $_POST['device'], $_POST['time'], $_POST['description']);
        elseif ($action === 'delete') deletePlan($_POST['id']);
        header('Location: index.php?page=plan'); exit();
    }
    $plans = getPlans();
    require_once "Views/plan.php";
}
elseif ($page === 'historybank') {
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

