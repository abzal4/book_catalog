<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php include "includes/navigation.php" ?>
    <div class="books__container">
        <form method="GET" id="searchForm">
            <div class="formTop">
                <div class="title__search">
                    <h1>Книги</h1>
                </div>
            </div>
        </form>
        <div id="result"></div>
        <div class="page__buttons">
            <button class="left__button"><</button>
            <p id="page__number">1</p>
            <button class="right__button">></button>
        </div>
        <button type="button" onclick="history.back()">Назад</button>
    </div>

    <script>

        $(document).ready(function () {
            function loadBooks() {
                $.ajax({
                    url: 'ajax/book_back.php',
                    type: 'GET',
                    data: { action: "favoriteBooks"},
                    success: function (response) {
                        $('#result').html(response);
                    },
                    error: function () {
                        $('#result').html('<p>Ошибка загрузки</p>');
                    }
                });
            }
            
            loadBooks();
        });
    </script>
</body>