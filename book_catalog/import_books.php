<?php include "includes/db.php"; ?>

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
            <div class="title__search">
                <h1>Импорт книг с Open Library</h1>
            </div>
            <label for="genre">Жанр:</label>
            <select name="genre" id="genre">
                <option value="Action">Боевик</option>
                <option value="Adventure">Приключения</option>
                <option value="Art">Искусство</option>
                <option value="Biography">Биография</option>
                <option value="Business">Бизнес</option>
                <option value="Children">Детская литература</option>
                <option value="Classic">Классика</option>
                <option value="Comics">Комиксы</option>
                <option value="Crime">Детектив</option>
                <option value="Drama">Драма</option>
                <option value="Education">Образование</option>
                <option value="Fantasy">Фэнтези</option>
                <option value="Fiction">Художественная литература</option>
                <option value="Health">Здоровье</option>
                <option value="History">История</option>
                <option value="Horror">Ужасы</option>
                <option value="Humor">Юмор</option>
                <option value="Manga">Манга</option>
                <option value="Mystery">Мистика</option>
                <option value="Philosophy">Философия</option>
                <option value="Poetry">Поэзия</option>
                <option value="Psychology">Психология</option>
                <option value="Religion">Религия</option>
                <option value="Romance">Роман</option>
                <option value="Science">Наука</option>
                <option value="Science_Fiction">Научная фантастика</option>
                <option value="Self_help">Саморазвитие</option>
                <option value="Sports">Спорт</option>
                <option value="Technology">Технологии</option>
                <option value="Thriller">Триллер</option>
                <option value="Travel">Путешествия</option>
            </select>
            <input type="hidden" name="search" value="1">
            <button type="submit" name="search">Загрузить</button>
        </form>
        <div id="result"></div><br>
        <div class="buttons">
            <button type="button" onclick="history.back()">Назад</button>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#searchForm').on('submit', function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: 'ajax/book_back.php',
                    type: 'POST',
                    data: formData + '&action=importBooks',
                    success: function (response) {
                        $('#result').html(response);
                    },
                    error: function () {
                        $('#result').html('<p>Ошибка импорта</p>');
                    }
                });
            });
        });
    </script>
</body>