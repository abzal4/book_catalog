
<?php
include "includes/session.php";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth__container">
        <h2 class="auth_title">Вход</h2>

        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>


        <form method="POST" id="loginForm">
            <input type="text" name="login" id="login" placeholder="Логин"> <br><br>
            <input type="password" name="password" id="password" placeholder="Пароль"> <br><br>
            <button type="submit" >Вход</button>
        </form>
        <br>
        <a href="registration.php">Зарегистрироваться</a>
        <?php
        if (isset($_GET['success'])) {
            echo "<p style='color:green;'>Вы успешно зарегистрировались! Теперь войдите в систему.</p>";
        }
        ?>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
const loginForm = document.getElementById('loginForm');
loginForm.addEventListener('submit', async function (event) {
    event.preventDefault();
    const formData = new FormData(loginForm);
    formData.append('action', 'login');
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
        window.location.href = 'index.php';

    } catch (error) {
        console.error(error);
        alert('Ошибка соединения с сервером');
    }
});
</script>