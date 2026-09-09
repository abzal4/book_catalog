<?php
require_once __DIR__ .'/../includes/db.php';
require_once __DIR__ ."/../controllers/UserController.php";
require_once __DIR__ ."/../controllers/FavoriteController.php";
require_once __DIR__ . '/../includes/session.php';

header('Content-Type: application/json; charset=utf-8');

$userId = $_SESSION['userId'] ?? "";
$action = $_POST['action'] ?? $_GET['action'] ?? "";

if ($userId!='') {
    $user_books = FavoriteController::getId($conn, $userId);
} else {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Не авторизован!'
    ]);
    exit;
}


if ($action == "getUser") {
    echo UserController::getById($conn, $userId);
    exit;
}

if ($action == "getAllUsers") {
    echo UserController::getAll($conn);
    exit;
}

if ($action == "getUsersAmount") {
    echo UserController::getAmount($conn);
    exit;
}

if ($action == "editLogin") {
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    echo UserController::updateLogin($conn, $userId, $login);
    exit;
}

if ($action == "editName") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);

    echo UserController::updateName($conn, $userId, $name);
    exit;
}


if ($action == "editImage") {

    $image = mysqli_real_escape_string($conn, $_POST['image']);

    echo UserController::updateImage($conn, $userId, $image);
    exit;
}


if ($action == "editPassword") {

    $password = mysqli_real_escape_string($conn, $_POST['password']);

    echo UserController::updatePassword($conn, $userId, $password);
    exit;
}