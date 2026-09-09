<?php
require_once "../includes/session.php";
include "../includes/db.php";
require_once "../controllers/BookController.php";
require_once "../controllers/OrderController.php";
require_once '../validators/IdValidator.php';


$userId = $_SESSION['userId'] ?? '';
$action = $_POST['action'] ?? $_GET['action'] ?? "";

if ($action === 'createOrder') {
    $result = OrderController::createOrder($conn, $userId);
    if (!$result['success']) {
        echo json_encode([
            'success' => false,
            'message' => $result['message']
        ]);
        exit;
    }
    echo json_encode($result);
    exit;
}

if ($action === 'getUserOrders') {
    $result = OrderController::getUserOrders($conn, $userId);
    if (!$result['success']) {
        echo json_encode([
            'success' => false,
            'message' => $result['message']
        ]);
        exit;
    }
    echo json_encode($result);
    exit;
}



