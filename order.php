<?php
include "includes/session.php";
include "includes/db.php";
require_once "controllers/BookController.php";
require_once "controllers/OrderController.php";

$userId = $_SESSION['userId'] ?? null;
$orderId = $_GET['id'] ?? null;
$order = [];
$orderResult = OrderController::getOrder($conn, $orderId, $userId, $_SESSION['role']);
if ($orderResult['success']) {
    $order = $orderResult['data'];
}
;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php require_once("includes/navigation.php") ?>
    <div class="body__container">
        <ol class="orders">
            <h2>3аказ</h2>
            <?php if ($orderResult['success']): 
                    $order = $orderResult['data'];
            ?>
            <li>
                <div class="list_left">
                    <p>Заказ №<?= $order['id'] ?></p>
                    <p>Дата: <?= $order['created_at'] ?></p>
                    <p>Статус: <?= $order['status'] ?></p>
                    <p>Сумма: <?= $order['total_price'] ?></p>
                </div>
                <ol class="list_right">
                    <h4>Товары</h4>
                    <?php foreach($order['items'] as $book): ?>
                        <li><?= $book['title'] ?>&nbsp;-&nbsp;<?= $book['quantity'] ?> шт.</li>
                    <?php endforeach; ?>
                </ol>
            </li>
            <?php endif; 
                    if (!$orderResult['success']) { 
                        echo $orderResult['message'];
                    }
            ?>
        </ol>
        <button class='btn-back' type="button" onclick="history.back()">Назад</button>
    </div>
</body>
<script>
</script>
</html>