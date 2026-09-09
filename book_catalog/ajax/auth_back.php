<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../controllers/UserController.php';

$action = $_POST['action'] ?? '';

if ($action === 'login') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $response = UserController::login($conn, $login, $password);
    $data = json_decode($response, true);

    if ($data['success']) {
        $user = $data['data'];
        session_regenerate_id(true);
        $_SESSION['userId'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['profile_image'] = $user['avatar'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['cart'] = [];
        $_SESSION['last_activity'] = time();

        echo $response;
        exit;
    }
    echo $response;
    exit;
}

if ($action == "register") {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $response = UserController::register($conn, $login, $name, $password);
    echo $response;
    exit;
}
return;