<?php
require_once "models.php";

$page = $_GET['page'] ?? 'dashboard';
$action = $_POST['action'] ?? '';
if ($page === 'plan') {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($action === 'add') addPlan($_POST['name'], $_POST['price'], $_POST['device'], $_POST['time'], $_POST['description']);
        elseif ($action === 'edit') updatePlan($_POST['id'], $_POST['name'], $_POST['price'], $_POST['device'], $_POST['time'], $_POST['description']);
        elseif ($action === 'delete') deletePlan($_POST['id']);
        header('Location: index.php?page=plan'); exit();
    }
    $plans = getPlans();
    require_once "Views/plan.php";
}
else {
    require_once "Views/dashboard.php";
}


?>