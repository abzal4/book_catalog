<?php

require_once 'session.php';

if (!isset($_SESSION['userId'])) {
    header("Location: /../login.php");
    exit;
}

function require_admin() {
    if (($_SESSION['role'] ?? null) !== 'admin') {
        http_response_code(403);
        exit('Доступ запрещён');
    }
}