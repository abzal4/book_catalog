<?php
include "includes/auth.php";
include "includes/db.php";
require_once "controllers/BookController.php";
require_once "controllers/OrderController.php";

$userId = $_SESSION['userId'] ?? null;
$userOrders =[];
$userOrdersResult = OrderController::getUserOrders($conn, $userId);
if ($userOrdersResult['success']) {
    $userOrders = $userOrdersResult['data'];
};


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
            <h2>3аказы</h2>
            <?php foreach($userOrders as $order): ?>
                <li>
                    <div class="list_left">
                        <h4><a href="order.php?id=<?= $order['id'] ?>" class="order_link">Заказ №<?= $order['id'] ?></a></h4>
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
            <?php endforeach; ?>
        </ol>
        <button class='btn-back' type="button" onclick="history.back()">Назад</button>
    </div>
</body>
<script>
// $(document).ready(async function () {
//     try {
//         const response = await fetch('ajax/order_back.php?action=getUserOrders');
//         const data = await response.json();
    
//         if (!response.ok || !data.success) {
//             alert(data.message);
//             return;
//         }
//         $('#result').html(data)
//     }
// });
</script>
</html>