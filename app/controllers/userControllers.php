<?php
require_once "models.php";

$page = $_GET['page'] ?? 'dashboard';
$action = $_POST['action'] ?? '';

if ($page === 'user') {
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
else {
    require_once "Views/dashboard.php";
}


?>