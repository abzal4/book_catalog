<?php 
include "includes/db.php"; 
include "includes/session.php";


if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit('Доступ запрещён <button type="button" onclick="history.back()">Назад</button>');
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
<body>  
    <?php 
        include "includes/navigation.php";
        require "includes/db.php";

        $id = $_GET['id'] ?? null;

        $sql = "select * from imported_books where id = " . $id;
        $result = mysqli_query($conn, $sql) ?? null;
        $currentBook = mysqli_fetch_assoc($result);

    ?>
    
    <div class="books__container">
        <div class="book__container">
            <div class="book__title_and_image">
                <img src="https://covers.openlibrary.org/b/id/<?=$currentBook['cover_i']?>.jpg" alt="" class="book_image">
                <!-- <div class="book__title">
                    <h3><span id="titleText"><?= $currentBook['title'] ?></span> <button id=<?=$currentBook["id"]?> class='changeTitle'>Изменить</button></h3>
                    <div class="book__text">
                        <div class="book__info">
                            <p>Автор: <span id="authorText"><?= $currentBook['author_name'] ?></span><button id=<?=$currentBook["id"]?> class='changeAuthor'>Изменить</button></p>
                            <p>Жанр: <span id="genreText"><?= $currentBook['genre'] ?></span> <button id='<?= $currentBook["id"] ?>' class='changeGenre'>Изменить</button></p>
                            <p>Год: <span id="yearText"><?= $currentBook['first_publish_year'] ?></span> <button id='<?= $currentBook["id"] ?>' class='changeYear'>Изменить</button></p>
                        </div>
                        <p><?= $currentBook['subtitle']?$currentBook['subtitle']:"" ?></p>
                    </div>
                </div> -->
                <div class="book__title">
                    <h3><span id="titleText"><?= $currentBook['title'] ?></span></h3>
                    <div class="book__text">
                        <div class="book__info">
                            <p>Автор: <span id="authorText"><?= $currentBook['author_name'] ?></span></p>
                            <p>Жанр: <span id="genreText"><?= $currentBook['genre'] ?></span> </p>
                            <p>Год: <span id="yearText"><?= $currentBook['first_publish_year'] ?></span> <button id='<?= $currentBook["id"] ?>' class='changeBook'>Изменить</button></p>
                        </div>
                        <p><?= $currentBook['subtitle']?$currentBook['subtitle']:"" ?></p>
                    </div>
                </div>
            </div>
            
            
            
            <div class="buttons">
                <button type="button" onclick="history.back()">Назад</button>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(".changeBook").click(function () {
    let button = $(this);
    if (button.data("editing") !== true) {
        let currentTitle = $("#titleText").text();
        let currentAuthor = $("#authorText").text();
        let currentGenre = $("#genreText").text();
        let currentYear = $("#yearText").text();
        $("#titleText").replaceWith(`<input type="text" id="new_title" value="${currentTitle}">`);
        $("#authorText").replaceWith(`<input type="text" id="new_author" value="${currentAuthor}">`);
        $("#genreText").replaceWith(`<input type="text" id="new_genre" value="${currentGenre}">`);
        $("#yearText").replaceWith(`<input type="text" id="new_year" value="${currentYear}">`);
        button.text("Сохранить");
        button.data("editing", true);
    } else {
        let bookId = button.attr('id');
        let title = $("#new_title").val();
        let author = $("#new_author").val();
        let genre = $("#new_genre").val();
        let year = $("#new_year").val();
        $.ajax({
            url: "ajax/book_back.php",
            type: "POST",
            data: { action: "editBook", title: title, author: author, genre: genre, year: year, bookId: bookId},
            success: function(response) {
                response = response.trim();
                if (response == "ok") {
                    $("#new_title").replaceWith(`<span id="titleText">${title}</span>`);
                    $("#new_author").replaceWith(`<span id="authorText">${author}</span>`);
                    $("#new_genre").replaceWith(`<span id="genreText">${genre}</span>`);
                    $("#new_year").replaceWith(`<span id="yearText">${year}</span>`);
                    button.text("Изменить");
                    alert("Книга изменена");
                    window.location.reload();
                } else {
                    alert(response);
                }
            }
        });
    }
});
</script>
</html>