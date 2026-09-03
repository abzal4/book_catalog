<?php 
foreach ($users as $user):
    ?>
<li>
    <div class = 'user_full_info'> 
        <div class = 'short_info' >
            <div class='profile_image'><img  src="<?= htmlspecialchars($user['avatar']) ?>" alt='pfp_image' onerror="this.onerror=null; this.src='../images/default_pfp.jpg';"></div> 
             <?= htmlspecialchars($user['name']) ?>
             (<?= $user['id'] ?>)
                - <?= htmlspecialchars($user['created_at']) ?>
            <button class ='deleteUser' id = "<?= $user['id'] ?>">Удалить</button>
            <p class = 'userImage'  id='imageText<?= $user['id'] ?>'></p>  <button class ='editImage' data-user-id="<?= $user['id'] ?>">Изменить аватарку</button>
        </div> 
        <div class = 'user_change'>
            <span>Имя: <p class = 'userName' id="nameText<?= $user['id'] ?>"><?= $user['name'] ?></p>  <button class='editName' data-user-id=<?= $user['id'] ?> >Изменить</button></span>
            <span>Логин: <p class = 'userLogin' id='loginText<?= $user['id'] ?>'><?= $user['login'] ?></p>  <button class='editLogin' data-user-id=<?= $user['id'] ?>>Изменить</button></span>
            <span>Пароль: <p class = 'userPassword'  id='passwordText<?= $user['id'] ?>'>******</p>  <button class='editPassword' data-user-id=<?= $user['id'] ?>>Изменить</button></span>
        </div>
    </div>
</li> 
<?php endforeach; ?>