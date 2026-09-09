<?php include "db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php
        
        require "db.php";

        $id = $_GET['id'] ?? null;

        $sql = "select * from books where id = " . $id;
        $result = mysqli_query($conn, $sql) ?? null;
        $currentBook = mysqli_fetch_assoc($result);
        
    ?>
    <div class="buy__container">
        <form method="POST" id="requestForm">
            <div class="title__request">
                <h2>Заявка на покупку</h2>
            </div>
            <label for="name">Имя:</label>
            <input type="text" name="name" placeholder="Name">
            <label for="number">Номер телефона   :</label>
            <input type="tel" name="number" placeholder="+7 (___) ___-__-__">
            <label for="email">Почта:</label>
            <input type="email" name="email" placeholder="example@gmail.com">
            <input type="hidden" name="book_id" value="<?= $currentBook['id'] ?>">
            <input type="hidden" name="book_title" value="<?= $currentBook['title'] ?>">
            <input type="hidden" name="book_price" value="<?= $currentBook['price'] ?>">
            <div class="buy__book-info">
                <p>Книга:</p>
                <h3><?= $currentBook['title'] ?></h3>
                <div class="book__info">
                    <p><?= $currentBook['author'] ?></p>
                    <p>Цена: <?= $currentBook['price'] ?></p>
                </div>
            </div>
            <button type="submit" name="request_button">Отправить заявку</button>
        </form>
        <div id="result"></div>
    </div>

    <script>
        const bookTitle = $('[name="book_title"]').val();
        const bookId = $('[name="book_id"]').val();
        const bookPrice = $('[name="book_price"]').val();
        const email = $('[name="email"]').val();
        const name = $('[name="name"]').val();

        $(document).ready(function () {
            $('#requestForm').on('submit', function (e) {
                e.preventDefault();

                const bookTitle = $('[name="book_title"]').val();
                const bookId = $('[name="book_id"]').val();
                const bookPrice = $('[name="book_price"]').val();
                const email = $('[name="email"]').val();
                const name = $('[name="name"]').val();

                var formData = $(this).serialize();

                $.ajax({
                    url: 'save_order.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#result').html(response);
                        const element = document.getElementById("requestForm");
                        element.innerHTML =
                        "Книга: " + bookTitle +
                        " - " + bookPrice + " тг; " + "<br>" +
                        "Email: " + email + ";<br>" +
                        "Имя: " + name;
                    },
                    error: function() {
                        $('#result').html('Ошибка');
                    }
                });
            });
        });
    </script>
</body>