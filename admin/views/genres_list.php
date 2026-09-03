<?php foreach ($genresWithAmount as $genre):?>
    <li><div class = 'full_info'>
        <p class='genreName'> <?= ($genre['genre']) ?></p> - <?= $genre['amount'] ?>
        <button class='deleteGenre'>Удалить</button>
    </div></li>
<?php endforeach; ?>