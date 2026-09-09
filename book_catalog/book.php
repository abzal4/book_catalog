<?php

include "includes/db.php";
include "includes/session.php";
require_once "controllers/BookController.php";
require_once "controllers/FavoriteController.php";

$userId = $_SESSION["userId"] ?? null;
$bookId = $_GET['id'] ?? null;

$currentBook = BookController::showOne($conn, $bookId);
$star = '';
$isFavorite = false;

if ($userId) {
    $user_books = FavoriteController::getId($conn, $userId);
    if (in_array($currentBook["id"], $user_books)) {
        $star = '⭐';
        $isFavorite = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Book</title>
</head>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<body>
    <?php include "includes/navigation.php"; ?>
    <div class="books__container">
        <?php include "views/books/show_book.php"; ?>
    </div>
</body>
<script>
$(document).ready(function () {
    let favButton = $(".favButton");
    let currentBook = <?= json_encode($currentBook) ?>;
    let isFavorite = <?= json_encode($isFavorite) ?>;
    if (isFavorite) {
        favButton.text("Удалить с избранных");
    } else {
        favButton.text("Добавить в избранное");
    }
    if (isFavorite) {
            $(".favButton").click(function () {
                if (!confirm("Вы точно хотите удалить эту книгу с избранных?")) {
                    return;
                }
                $.ajax({
                    url: "ajax/book_back.php",
                    type: "POST",
                    data: { action: "delFromFav", bookId: currentBook['id'] },
                    success: function(response) {
                        response = response.trim();
                        if (response == "ok") {
                            alert("Книга удалена с избранных");
                            window.location.reload();
                        } else {
                            alert(response);
                        }
                        }
                    });
                }
            );
    } else {
        $(".favButton").click(function () {
                $.ajax({
                    url: "ajax/book_back.php",
                    type: "POST",
                    data: { action: "addToFav",bookId: currentBook['id'] },
                    success: function(response) {
                        response = response.trim();
                        if (response == "ok") {
                            alert("Книга добавлена в избранное");
                            window.location.reload();
                        } else {
                            alert(response);
                        }
                        }
                    });
                }
            );
        
    };
    $(".button__add_cart").click(async function () {
        const formData = new FormData;
        formData.append('action' , 'addToCart');
        formData.append('bookId' , currentBook['id']);
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
            alert("Книга добавлена в корзину!");
            $(".button__add_cart span").text(parseInt($( '.button__add_cart span' ).text(), 10)+1);
            console.log(data.cart);
        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
    });
})
</script>
</html>