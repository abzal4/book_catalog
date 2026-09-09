<?php
require_once __DIR__ .'/../includes/db.php';
require_once __DIR__ ."/../controllers/UserController.php";
require_once __DIR__ . '/../includes/auth.php';

$userId = $_SESSION['userId'];
$action = $_POST['action'] ?? $_GET['action'] ?? " ";


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