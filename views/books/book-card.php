
<br><br><b style='font-size: 20px;'>Результаты поиска</b>
<p>Жанр: <?= $genre ?? "все" ?></p><br><br>
<div class='books'>
    <?php foreach ($books_array as $book): ?>
        <div class="book__card">
            <a href="book.php?id=<?= $book["id"] ?>">
                <?= $book["title"] ?> (<?= $book["first_publish_year"] ?>)
                <img src="https://covers.openlibrary.org/b/id/<?= $book['cover_i'] ?>.jpg" alt="" class="book_image" loading="lazy" onerror="this.onerror=null; this.src='/../images/book_cover.png';">
                <?= $book["genre"] ?> - <?= $book["author_name"] ?><br>
                Подробнее
            </a>
            <button type="button" id = <?= $book['id'] ?> class="button__add_cart">Добавить в корзину - <span><?= $_SESSION['cart'][$book['id']] ?? 0 ?></span>шт</button>
        </div>
    <?php endforeach; ?>
</div>