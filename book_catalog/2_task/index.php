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
    <div class="books__container">
        
        <form method="GET" id="searchForm">
            <div class="title__search">
                <h1>Книги</h1>
                <input type="search" name="search_book" id="search_book" placeholder="Название книги или автор"> <br>
            </div>
            <label for="genre">Жанр:</label>
            <select name="genre" id="genre">
                <option value="Все">Все</option>
                <option value="Роман">Роман</option>
                <option value="Фэнтези">Фэнтези</option>
                <option value="Драма">Драма</option>
                <option value="Научная фантастика">Научная фантастика</option>
            </select>
            <label for="price">Цена:</label>
            <input type="number" name="min_price" placeholder="От">
            <input type="number" name="max_price" placeholder="До">
            <input type="hidden" name="search" value="1">
            <button type="submit" name="search">Найти</button>
        </form>

        <div id="result"></div>
    </div>

    <script>
        $(document).ready(function () {
            $('#searchForm').on('submit', function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: 'loads_books.php',
                    type: 'GET',
                    data: formData,
                    success: function (response) {
                        $('#result').html(response);
                    },
                    error: function () {
                        $('#result').html('<p>Ошибка загрузки</p>');
                    }
                });
            });
        });
    </script>
</body>