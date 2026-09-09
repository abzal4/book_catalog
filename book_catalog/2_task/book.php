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

        require "db.php";

        $id = $_GET['id'] ?? null;

        $sql = "select * from books where id = " . $id;
        $result = mysqli_query($conn, $sql) ?? null;
        $currentBook = mysqli_fetch_assoc($result);

    ?>

    <div class="book__container">
        <div class="book__title">
            <h3><?= $currentBook['title'] ?></h3>
        </div>
        
        <div class="book__text">
            <div class="book__info">
                <p>Автор: <?= $currentBook['author'] ?></p>
                <p>Жанр: <?= $currentBook['genre'] ?></p>
                <p>Год: <?= $currentBook['year'] ?></p>
                <p>Цена: <?= $currentBook['price'] ?></p>
            </div>
            <p><?= $currentBook['description'] ?></p>
        </div>
        <div class="buttons">
            <a href='index.php'>Назад</a>
            <a class="button__buy" href="buy_book.php?id=<?= $currentBook['id'] ?>">Купить</a>
        </div>
        
    </div>
</body>
</html>