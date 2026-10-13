<?php
session_start();
$page = $_GET['page'] ?? 'dashboard';
if (!isset($_SESSION['user_id']) && $page !== 'login') {
    header("Location: index.php?page=login");
    exit();
}
require_once 'database/database.php'; 

require_once 'app/models/bankModels.php';
require_once 'app/models/planModels.php';
require_once 'app/models/historyModels.php';
require_once 'app/models/userModels.php';

require_once 'app/controllers/loginControllers.php';
require_once 'app/controllers/bankControllers.php';
require_once 'app/controllers/planControllers.php';
require_once 'app/controllers/historyControllers.php';
require_once 'app/controllers/userControllers.php';

if ($page === 'login') {
    $controller = new LoginControllers(new UserModel($pdo));
    $controller->login();
}
elseif ($page === 'logout') {
    $controller = new LoginControllers(new UserModel($pdo));
    $controller->logout();
}
elseif ($page === 'bank') {
    $controller = new BankController(new BankModel($pdo));
    $controller->handleRequest();
} 
elseif ($page === 'plan') {
    $controller = new PlanController(new PlanModel($pdo));
    $controller->handleRequest();
} 
elseif ($page === 'historybank') {
    $controller = new HistoryController(new HistoryModel($pdo));
    $controller->handleBankRequest();
} 
elseif ($page === 'historyplan') {
    $controller = new HistoryController(new HistoryModel($pdo));
    $controller->handlePlanRequest();
} 
elseif ($page === 'user') {
    $controller = new UserController(new UserModel($pdo), new PlanModel($pdo));
    $controller->handleRequest();
} 
else {
    require_once 'app/view/dashboard/dashboard.php';
}
?>