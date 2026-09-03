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
                    <input type="search" name="search_book" id="search_book" placeholder="Название книги или автор"> 
                </div>
                <div class="limit">
                    <p>Лимит:</p>
                    <input type="number" name="limit" id="limit" value=10> 
                </div>
            </div>
            <label for="genre">Жанр:</label>
            <select name="genre" id="genre">
                <option value="Все">Все</option>
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
            <label for="genre">Сортировка по алфавиту:</label>
            <select name="order_by" id="order_by">
                <option value="asc">A-Z</option>
                <option value="desc">Z-A</option>
            </select>
            <input type="hidden" name="search" value="1">
            <input type="hidden" name="page" id="page" value="1">
            <button type="submit" name="search">Найти</button>
        </form>
        <button onclick="window.location.href='import_books.php'">Импортировать книги</button>
        <div id="result"></div>
        <div class="page__buttons">
            <button class="left__button"><</button>
            <p id="page__number">1</p>
            <button class="right__button">></button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadBooks() {
                fetch('ajax/book_back.php?' + $('#searchForm').serialize() + '&action=getBooks')
                    .then(response => response.text())
                    .then(data => $('#result').html(data))
            }
            
            function editPageNumber() {
                 $('#page__number').text($('#page').val());
            }

            $('#searchForm').on('submit', function (e) {
                    e.preventDefault();
                    $('#page').val(1);
                    loadBooks();
            });

            $('.right__button').on('click', function () {
                let page = parseInt($('#page').val());
                $('#page').val(page + 1);
                editPageNumber();
                loadBooks();
            });

            $('.left__button').on('click', function () {
                let page = parseInt($('#page').val());

                if (page > 1) {
                    $('#page').val(page - 1);
                    editPageNumber();
                    loadBooks();
                }
            });
            
            loadBooks();

            $("#result").on('click', ".button__add_cart", async function () {
                const formData = new FormData;
                formData.append('action' , 'addToCart');
                formData.append('bookId' , $(this).attr('id'));
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
                    $(this).find("span").text(parseInt($(this).find("span").text(), 10)+1);
                    console.log(data.cart);
                } catch (error) {
                    console.error(error);
                    alert('Ошибка соединения с сервером');
                }
            });
        });
    </script>
</body>