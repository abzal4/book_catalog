<?php 
include __DIR__ .'/../includes/db.php'; 
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ .'/../controllers/BookController.php';
require_once __DIR__ .'/../controllers/GenreController.php';
require_once __DIR__ .'/../controllers/OrderController.php';
$users = json_decode(UserController::getAll($conn),  true)['data'];
$users_amount = json_decode(UserController::getAmount($conn),  true)['data'];
$genresWithAmount = GenreController::getAllWithAmount($conn);
$genre_amount = GenreController::getAmount($conn);
$books_amount = BookController::getAmount($conn);
$orders_amount = OrderController::getAllAmount($conn)['data'];
$orders = OrderController::getAllOrders($conn)['data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php include "../includes/navigation.php" ?>
    <div class="admin__container">
        <div class="nav__buttons">
            <button class="books_section_btn">Книги</button>
            <button class="genres_section_btn">Жанры</button>
            <button class="users_section_btn">Пользователи</button>
            <button class="orders_section_btn">Заказы</button>
        </div>
        <div class="admin__sections">
            <div class="admin__section books__section"> 
                <form method="GET" id="searchForm">
                    <div class="formTop">
                        <div class="title__search">
                            <h3>Книги</h3> 
                            <input type="search" name="search_book" id="search_book" placeholder="Название книги или автор"> <br>
                        </div>
                        <div class="limit">
                            <p>Лимит:</p>
                            <input type="number" name="limit" id="limit" value=50> 
                        </div>
                    </div>
                    <label for="genre">Жанр:</label>
                    <select name="genre" >
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
                    <button onclick="window.location.href='../import_books.php'">Импортировать книги</button>
                </form>
                <br><br>
                <form method="POST" id="createBookForm">
                    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

                    <input type="text" name="title" id="title" placeholder="Название книги" required >
                    <br><br>

                    <input type="text" name="author" id="author" placeholder="Автор" required >
                    <br><br>

                    <select name="genre" id="createdGenre" required>
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
                    <br><br>
                    <input type="number" name="year" id="year" placeholder="Год публикации" min="0" required >
                    <br><br>
                    <button type="submit" name="createBook">
                        Добавить книгу
                    </button>
                </form>
                <div>
                    <p><?php echo $books_amount['books_amount'];?> книг в базе данных:</p>
                    <ol class="section__list" id="result"></ol>
                    <div class="page__buttons">
                        <button class="left__button"><</button>
                        <p id="page__number">1</p>
                        <button class="right__button">></button>
                    </div>
                </div>
            </div>
            <div class="admin__section genres__section">  
                <h3>Жанры</h3>
                <div class="section__info">
                    <p><?php echo $genre_amount['genre_amount'];?> жанров в базе данных:</p>
                    <ol class="section__list">
                        <?php include "../admin/views/genres_list.php"; ?>
                    </ol>
                </div>
            </div>
            <div class="admin__section users__section">  
                <h3>Пользователи</h3>
                <div class="section__info">
                    <p><?php echo $users_amount['users_amount'];?> пользователей в базе данных:</p>
                    <ol class="section__list">
                        <?php include "../admin/views/users_list.php"; ?>
                    </ol>
                    <br>
                    <button class='addUser'>Добавить пользователя</button>
                    <br><br>
                    <div class="addUserSection">
                        <form method="POST" id="registrationForm">
                            <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
                            <input type="text" name="name" id="name" placeholder="Имя"> <br><br>
                            <input type="text" name="login" id="login" placeholder="Логин"> <br><br>
                            <input type="password" name="password" id="password" placeholder="Пароль"> <br><br>
                            <button type="submit" name="register">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="admin__section orders__section">  
                <h3>Заказы</h3>
                <div class="section__info">
                    <p>Заказов в БД: <?php echo $orders_amount['amount'];?></p>
                    <ol class="section__list">
                        <?php include "../admin/views/orders_list.php"; ?>
                    </ol>
                </div>
            </div>
        </ul>
        <br><br>
        <div class="buttons">
            <button type="button" class='button_back' onclick="history.back()">Назад</button>
        </div>
    </div>
</body>
<script>

$(document).ready(async function () {

    function loadBooks() {
        fetch('../ajax/admin_back.php?' + $('#searchForm').serialize() + '&action=getBooks')
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
});

$(document).on("click", ".deleteBook", function () {
        if (!confirm("Вы точно хотите удалить эту книгу?")) {
            return;
        }
        let bookId = $(this).attr('id');
        $.ajax({
            url: "../ajax/admin_back.php",
            type: "POST",
            data: { action: "bookDelete", bookId: bookId },
            success: function(response) {
                response = response.trim();
                if (response == "ok") {
                    alert("Книга удалена");
                    window.location.reload();
                } else {
                    alert(response);
                }
            }
        });
    }
);

const createBookForm = document.getElementById('createBookForm');
createBookForm.addEventListener("submit", function (event) {
    event.preventDefault(); 
    const formData = new FormData(createBookForm); 
    formData.append("action", "createBook");
    fetch( "../ajax/book_back.php", { 
        method: "POST",
        body: formData
    })
    .then(response => response.text()) 
    .then(responseText => {
        responseText = responseText.trim();
        if (responseText === "ok") {
            alert("Книга создана");
            window.location.reload();

        } else {
            alert(responseText);
        }
    })
})

$(".deleteGenre").click(function () {
        if (!confirm("Вы точно хотите удалить этот жанр и все книги с этим жанром?")) {
            return;
        }
        let genre = $(this).siblings(".genreName").text();
        $.ajax({
            url: "../ajax/admin_back.php",
            type: "POST",
            data: { action: "genreDelete", genre: genre },
            success: function(response) {
                response = response.trim();
                if (response == "ok") {
                    alert("Жанр удален");
                    window.location.reload();
                } else {
                    alert(response);
                }
            }
        });
    }
);

$(".deleteUser").click(async function () {
        if (!confirm("Вы точно хотите удалить этого пользователя?")) {
            return;
        }
        let userId = $(this).attr('id');
        try {
            const formData = new FormData();
            formData.append("action", "userDelete");
            formData.append("userId", userId);
            const response = await fetch('/../ajax/admin_back.php', {
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
            }
            alert("Пользователь удален!");
            window.location.reload();
        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
    }
);

$(".editName").click(async function () {
    let button = $(this);
    let userId = button.data("user-id");
    if (button.data("editing") !== true) {
        let currentName = $("#nameText" + userId).text();
        $("#nameText" + userId).replaceWith(`<input type="text" id="new_name${userId}" value="${currentName}">`);
        button.text("Сохранить");
        button.data("editing", true);
    } else {
        let name = $("#new_name" + userId).val();
        try {
            const formData = new FormData();
            formData.append("action", "editName");
            formData.append("userId", userId);
            formData.append("name", name);
            const response = await fetch('/../ajax/admin_back.php', {
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
            }
            alert("Имя изменено");
            window.location.reload();
        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
    }
});

$(".editLogin").click(async function () {
    let button = $(this);
    let userId = button.data("user-id");
    if (button.data("editing") !== true) {
        let currentLogin = $("#loginText" + userId).text();
        $("#loginText" + userId).replaceWith(`<input type="text" id="new_login${userId}" value="${currentLogin}">`);
        button.text("Сохранить");
        button.data("editing", true);
    } else {
        let login = $("#new_login" + userId).val();
        try {
            const formData = new FormData();
            formData.append("action", "editLogin");
            formData.append("userId", userId);
            formData.append("login", login);
            const response = await fetch('/../ajax/admin_back.php', {
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
            }
            alert("Логин изменён");
            window.location.reload();
        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
    }
});

$(".editImage").click(async function () {
    let button = $(this);
    let userId = button.data("user-id");
    if (button.data("editing") !== true) {
        let currentImage = $("#imageText" + userId).text();
        $("#imageText" + userId).replaceWith(`<input type="text" id="new_image${userId}" value="${currentImage}">`);
        button.text("Сохранить");
        button.data("editing", true);
    } else {
        let image = $("#new_image" + userId).val();
        try {
            const formData = new FormData();
            formData.append("action", "editImage");
            formData.append("userId", userId);
            formData.append("image", image);
            const response = await fetch('/../ajax/admin_back.php', {
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
            }
            alert("Изображение изменено");
            window.location.reload();
        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
    }
});

$(".editPassword").click(async function () {
    let button = $(this);
    let userId = button.data("user-id");
    if (button.data("editing") !== true) {
        $("#passwordText" + userId).replaceWith(`<input type="text" id="new_password${userId}" value="">`);
        button.text("Сохранить");
        button.data("editing", true);
    } else {
        let password = $("#new_password" + userId).val();
        try {
            const formData = new FormData();
            formData.append("action", "editPassword");
            formData.append("userId", userId);
            formData.append("password", password);
            const response = await fetch('/../ajax/admin_back.php', {
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
            }
            alert("Пароль изменен");
            window.location.reload();
        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
    }
});

$(".btn-change_status").click(async function () {
    let button = $(this);
    let orderId = button.data("orderId");
    let selectStatus = button.siblings('.selectStatus');
    if (button.data("editing") !== true) {
        let oldStatus = button.find('b');
        oldStatus.hide();
        selectStatus.show();
        button.text("Сохранить");
        button.data("editing", true);
    } else {
        let newStatus = selectStatus.val();
        try {
            const formData = new FormData();
            formData.append("action", "editStatus");
            formData.append("orderId", orderId);
            formData.append("newStatus", newStatus);
            console.log(orderId);
            console.log(newStatus);
            const response = await fetch('/../ajax/admin_back.php', {
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
            }
            alert("Статус изменен");
            window.location.reload();
        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
    }
});

$(".addUser").click(function () {
    $(".addUserSection").toggle();
});

const registrationForm = document.getElementById('registrationForm');
registrationForm.addEventListener("submit", async function (event) {
    event.preventDefault(); 
    const formData = new FormData(registrationForm); 
    formData.append("action", "register");
    try {
            const response = await fetch('/ajax/auth_back.php', {
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
            }
            alert('Пользователь создан!')

        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
});

const sections = document.querySelectorAll(".admin__section");

const buttons = {
    books: document.querySelector(".books_section_btn"),
    genres: document.querySelector(".genres_section_btn"),
    users: document.querySelector(".users_section_btn"),
    orders: document.querySelector(".orders_section_btn")
};

buttons.books.addEventListener("click", function () {
    showSection(".books__section");
});

buttons.genres.addEventListener("click", function () {
    showSection(".genres__section");
});

buttons.users.addEventListener("click", function () {
    showSection(".users__section");
});
buttons.orders.addEventListener("click", function () {
    showSection(".orders__section");
});

function showSection(sectionClass) {
    sections.forEach(section => {
        section.classList.remove("active");
        section.classList.add("hidden");
    });

    document.querySelector(sectionClass).classList.remove("hidden");
    document.querySelector(sectionClass).classList.add("active");
}
</script>
</html>