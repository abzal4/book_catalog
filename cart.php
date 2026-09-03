<?php
include "includes/session.php";
include "includes/db.php";
include "includes/session.php";
require_once "controllers/BookController.php";

$userId = $_SESSION['userId'] ?? null;
$cartBookIds = $_SESSION['cart'] ?? [];
$total_price = 0;
$cartBooks = [];

foreach ($cartBookIds as $bookId => $quantity) {
    $book = BookController::showOne($conn, $bookId);
    $book['quantity'] = $quantity;
    $book['price'] = '750';
    $cartBooks[] = $book; 
    $total_price += $book['quantity'] * $book['price'];
}
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
        <ul class="cart_books">
            <h2>Корзина</h2>
            <?php foreach($cartBooks as $book): ?>
                <li class="cart_book" id="<?= $book['id'] ?>">
                    <span class="book_title">  <?= htmlspecialchars($book['title']) ?> </span> &nbsp;-&nbsp;
                    <span class="book_author"> <?= htmlspecialchars($book['author_name']) ?> </span>
                    (<span class="book_price"><?= $book['price'] ?></span> тг):
                    <button class="btn_amount_down">-</button>
                    <span class="book_quantity"> <?= $book['quantity'] ?> </span> шт
                    <button class="btn_amount_up">+</button> -
                    <span class="book_total_price"> <?= $book['quantity'] * $book['price'] ?> </span> тг
                </li>
            <?php endforeach; ?>
            <p class="cart_total_price">Общая сумма: <?= $total_price ?>тг</p>
            <button type="button" class="btn-modal-order">Оформить заказ</button>
        </ul>
    </div>
    <div class="modal" id="modal-order">
        <div class="modal__container">
            <div class="modal__body">
                <ol class="order">
                    <h2>Заказ</h2>
                    <?php foreach($cartBooks as $book): ?>
                        <li class="cart_book" id="<?= $book['id'] ?>">
                            <span class="book_title">  <?= htmlspecialchars($book['title']) ?> </span> &nbsp;-&nbsp;
                            <span class="book_author"> <?= htmlspecialchars($book['author_name']) ?> </span>
                            (<span class="book_price"><?= $book['price'] ?></span> тг):
                            <span class="book_quantity"> <?= $book['quantity'] ?> </span> шт -
                            <span class="book_total_price"> <?= $book['quantity'] * $book['price'] ?> </span> тг
                        </li>
                    <?php endforeach; ?>
                    <p class="cart_total_price">Общая сумма: <?= $total_price ?>тг</p>
                    <button type="button" class="button__make_order">Отправить заявку</button>
                    <p class="order_result"></p>
                </ol>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        function updateCart(data) {
            const cart = data.cart;
            let totalPrice = 0;
            $(".cart_book").each(function () {
                const bookId = $(this).attr("id");
                const quantity = cart[bookId] ?? 0;
                const price = parseInt($(this).find(".book_price").text(), 10);
                const itemTotal = quantity * price;
                $(this).find(".book_quantity").text(quantity);
                $(this).find(".book_total_price").text(itemTotal);
                totalPrice += itemTotal;
            });
            $(".cart_total_price").text( "Общая сумма: " + totalPrice + " тг");
        }

        $(".btn_amount_up").click(async function () {
            const formData = new FormData;
            formData.append('action' , 'addToCart');
            formData.append('bookId' , $(this).parent().attr('id'));
            try {
                const response = await fetch('ajax/book_back.php', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await response.json();
                if (!response.ok || !data.success) {
                    alert(data.message);
                    return;
                };
                updateCart(data);
                console.log(data.cart);
            } catch (error) {
                console.error(error);
                alert('Ошибка соединения с сервером');
            }
        });
        
        $(".btn_amount_down").click(async function () {
            const formData = new FormData;
            formData.append('action' , 'removeFromCart');
            formData.append('bookId' , $(this).parent().attr('id'));
            try {
                const response = await fetch('ajax/book_back.php', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await response.json();
                if (!response.ok || !data.success) {
                    alert(data.message);
                    return;
                };
                updateCart(data);
                console.log(data.cart);
            } catch (error) {
                console.error(error);
                alert('Ошибка соединения с сервером');
            }
        });

        $(".button__make_order").click(async function () {
            const formData = new FormData;
            formData.append('action' , 'createOrder');
            try {
                const response = await fetch('ajax/order_back.php', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await response.json();
                if (!response.ok || !data.success) {
                    alert(data.message);
                    return;
                };
                alert("Заказ сделан!");
                $(".button__make_order").text("");
                $(".order_result").text("Заказ успешно создан!");
            } catch (error) {
                console.error(error);
                alert('Ошибка соединения с сервером');
            }
        });

        const modal = $("#modal-order");
        const modalContainer = modal.find(".modal__container");
        const openModalButton = $(".btn-modal-order");
        const closeButton = $(".modal__close");

        openModalButton.on("click", function () {
            modal.addClass("active");
            modalContainer.addClass("active");
        });

        closeButton.on("click", function () {
            closeModal();
        });

        modal.on("click", function (event) {
            if ($(event.target).is(modal)) {
                closeModal();
            }
        });

        function closeModal() {
            modal.removeClass("active");
            modalContainer.removeClass("active");
        }
            });
</script>
</html>