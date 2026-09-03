<div class="book__container">
    <div class="book__title_and_image">
            <img src="https://covers.openlibrary.org/b/id/<?=$currentBook['cover_i']?>.jpg" alt="" class="book_image" onerror="this.onerror=null; this.src='/../images/book_cover.png';">
            <div class="book__title">
                <h3><?= $currentBook['title']  . $star ?? "" ?></h3>
                <div class="book__text">
                    <div class="book__info">
                        <p>Автор: <?= $currentBook['author_name']?></p>
                        <p>Жанр: <?= $currentBook['genre'] ?></p>
                        <p>Год: <?= $currentBook['first_publish_year'] ?></p>
                    </div>
                    <p><?= $currentBook['subtitle']?$currentBook['subtitle']:"" ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="buttons">
        <button type="button" onclick="history.back()">Назад</button>
        <div class="buttons__right-box">
            <button type="button" id = <?= $currentBook['id'] ?> class="button__add_cart">Добавить в корзину - <span><?= $_SESSION['cart'][$bookId] ?? 0 ?></span>шт</button>
            <button type="button" id = <?= $currentBook['id'] ?> class = "favButton">Добавить в избранное</button>
        </div>
    </div>
</div>